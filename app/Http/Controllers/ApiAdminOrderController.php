<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Services\FirebaseService;

use App\Models\User;
use App\Models\Slider;
use App\Models\SliderLang;
use App\Models\ProductCategory;
use App\Models\ProductCategoryLang;
use App\Models\Product;
use App\Models\ProductLang;
use App\Models\Brand;
use App\Models\Goal;
use App\Models\Tag;
use App\Models\Language;
use App\Models\BrandLang;
use App\Models\GoalLang;
use App\Models\TagLang;
use App\Models\News;
use App\Models\NewsLang;
use App\Models\NewsCategory;
use App\Models\NewsCategoryLang;
use App\Models\Video;
use App\Models\VideoLang;
use App\Models\VideoCategory;
use App\Models\VideoCategoryLang;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\City;
use App\Models\Subcity;
use App\Models\Office;
use App\Models\OfficeSubcity;


class ApiAdminOrderController extends Controller
{
    public function getOrders($type_id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        if ($user->is_admin !== 1) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if (!is_numeric($type_id)) {
            return response()->json(['error' => 'Invalid type_id'], 400);
        }

        $languageId = $user->lang_id ?? config('app.default_language_id', 1);

        $orders = Transaction::where('transaction_type_id', $type_id)
            ->where('office_id', $user->office_id)
            ->with([
                'items:id,transaction_id,product_id,taste_id,currency_id,quantity,price_per_unit,total_price',
                'items.product.langs' => fn($query) => $query->where('language_id', $languageId),
                'items.taste.langs' => fn($query) => $query->where('language_id', $languageId),
                'items.currency:id,name',
                'transactionType:id,name',
                'payments.paymentMethod:id,name',   // eager load payments with method
                'payments.currency:id,name',        // eager load payment currency
            ])
            ->select('id', 'total_price', 'created_at', 'transaction_type_id')
            ->get();

        if ($orders->isEmpty()) {
            return response()->json(['error' => 'No orders found'], 404);
        }

        return response()->json(
            $orders->map(function ($order) use ($languageId) {
                return [
                    'id'                  => $order->id,
                    'total_price'         => $order->total_price,
                    'created_at'          => $order->created_at,
                    'transaction_type_id' => $order->transaction_type_id,
                    'transactionType'     => $order->transactionType?->name
                                            ?? ($order->transaction_type_id ? 'Unknown' : 'Not selected'),

                    // Payments list
                    'payments' => $order->payments->map(function ($payment) {
                        return [
                            'payment_id'     => $payment->id,
                            'amount'         => $payment->amount,
                            'currency'       => $payment->currency?->name ?? 'Unknown',
                            'payment_method' => $payment->paymentMethod?->name ?? 'Unknown',
                            'paid_at'        => $payment->paid_at,
                            'reference'      => $payment->reference,
                            'note'           => $payment->note,
                        ];
                    }),

                    // Items list
                    'items' => $order->items->map(function ($item) use ($languageId) {
                        return [
                            'item_id'        => $item->id,
                            'product_id'     => $item->product_id,
                            'taste_id'       => $item->taste_id,
                            'product_name'   => $item->product
                                                ? ($item->product->lang($languageId)?->name ?? 'Unknown')
                                                : 'Unknown',
                            'taste_name'     => $item->taste
                                                ? ($item->taste->lang($languageId)?->name ?? 'Unknown')
                                                : 'Unknown',
                            'currency_name'  => $item->currency?->name ?? 'Unknown',
                            'quantity'       => $item->quantity,
                            'price_per_unit' => $item->price_per_unit,
                            'total_price'    => $item->total_price,
                        ];
                    }),
                ];
            })
        );
    }
    public function getOrder($order_id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        if ($user->is_admin !== 1) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if (!is_numeric($order_id)) {
            return response()->json(['error' => 'Invalid order_id'], 400);
        }

        $languageId = $user->lang_id ?? config('app.default_language_id', 1);

        $order = Transaction::where('id', $order_id)
            ->where('office_id', $user->office_id) // optional: restrict to admin's office
            ->with([
                'items:id,transaction_id,product_id,taste_id,currency_id,quantity,price_per_unit,total_price',
                'items.product.langs' => fn($query) => $query->where('language_id', $languageId),
                'items.taste.langs' => fn($query) => $query->where('language_id', $languageId),
                'items.currency:id,name',
                'transactionType:id,name',
                'payments.paymentMethod:id,name',
                'payments.currency:id,name',
            ])
            ->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        return response()->json([
            'id'                  => $order->id,
            'total_price'         => $order->total_price,
            'created_at'          => $order->created_at,
            'transaction_type_id' => $order->transaction_type_id,
            'transactionType'     => $order->transactionType?->name ?? 'Unknown',

            'payments' => $order->payments->map(function ($payment) {
                return [
                    'payment_id'     => $payment->id,
                    'amount'         => $payment->amount,
                    'currency'       => $payment->currency?->name ?? 'Unknown',
                    'payment_method' => $payment->paymentMethod?->name ?? 'Unknown',
                    'paid_at'        => $payment->paid_at,
                    'reference'      => $payment->reference,
                    'note'           => $payment->note,
                ];
            }),

            'items' => $order->items->map(function ($item) use ($languageId) {
                return [
                    'item_id'        => $item->id,
                    'product_id'     => $item->product_id,
                    'taste_id'       => $item->taste_id,
                    'product_name'   => $item->product
                                        ? ($item->product->lang($languageId)?->name ?? 'Unknown')
                                        : 'Unknown',
                    'taste_name'     => $item->taste
                                        ? ($item->taste->lang($languageId)?->name ?? 'Unknown')
                                        : 'Unknown',
                    'currency_name'  => $item->currency?->name ?? 'Unknown',
                    'quantity'       => $item->quantity,
                    'price_per_unit' => $item->price_per_unit,
                    'total_price'    => $item->total_price,
                ];
            }),
        ]);
    }


    public function AcceptOrder($id)
    {
        $user = Auth::user();
        if ($user->is_admin != '1') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $order = Transaction::find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $order->transaction_type_id = 2;
        $order->save();

        return response()->json(['message' => 'Order accepted successfully']);
    }

    public function DeliveryOrder($id , Request $request)
    {
        $user = Auth::user();
        if ($user->is_admin != '1') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $order = Transaction::find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $order->transaction_type_id = 5;
        $order->taxi_id = $request->input('taxi_id');
        $order->taxi_garawatawa =0;
        $order->who_loan = 2;
        $order->save();

        return response()->json(['message' => 'Order delivered successfully']);
    }


    public function CompleteOrder($id)
    {
        $user = Auth::user();
        if ($user->is_admin != '1') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $order = Transaction::find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $order->transaction_type_id = 6;

        $order->save();

        return response()->json(['message' => 'Order completed successfully']);
    }

    public function RejectOrder($id)
    {
        $user = Auth::user();
        if ($user->is_admin != '1') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $order = Transaction::find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $order->transaction_type_id = 7;
        $order->save();

        return response()->json(['message' => 'Order rejected successfully']);
    }




}
