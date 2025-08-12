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
    public function GetOrders($type_id)
    {
        $user = Auth::user();
        if ($user->is_admin != '1') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $orders = Transaction::where('transaction_type_id', $type_id)
            ->where('office_id', $user->office_id)
            ->with([
                'items:id,transaction_id,product_id,taste_id,currency_id,quantity,price_per_unit,total_price',
                'items.product:id',
                'items.taste:id',
                'items.currency:id,name'
            ])
            ->select('id', 'total_price', 'created_at')
            ->get();

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No orders found'], 404);
        }

        $languageId = $user->lang_id;

        return response()->json(
            $orders->map(function ($order) use ($languageId) {
                return [
                    'id' => $order->id,
                    'total_price' => $order->total_price,
                    'created_at' => $order->created_at,
                    'items' => $order->items->map(function ($item) use ($languageId) {
                        return [
                            'item_id' => $item->id,
                            'product_id' => $item->product_id,
                            'taste_id' => $item->taste_id,
                            'product_name' => $item->product?->lang($languageId)?->name,
                            'taste_name' => $item->taste?->lang($languageId)?->name,
                            'currency_name' => $item->currency?->name,
                            'quantity' => $item->quantity,
                            'price_per_unit' => $item->price_per_unit,
                            'total_price' => $item->total_price,
                        ];
                    }),
                ];
            })
        );
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
