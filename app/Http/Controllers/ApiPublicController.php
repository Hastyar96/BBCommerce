<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Session;

use App\Http\Resources\ProductResource;
use App\Http\Resources\SingleProductResource;

use App\Services\StockService;
use App\Services\StockServiceItem;

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
use App\Models\CountryCode;
use App\Models\PaymentMethod;

class ApiPublicController extends Controller
{

   public function __construct(Request $request)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            $this->middleware('auth:sanctum');
        } else {
            $this->middleware(function ($request, $next) {
                $guestUserId = session('guest_user_id');
                $guestUser = $guestUserId ? User::find($guestUserId) : null;

                if (!auth()->check() || !$guestUser) {
                    // Either not logged in or guest user was deleted
                    $sessionId = session()->getId();

                    $existingGuest = User::where('is_guest', 1)
                        ->where('session', $sessionId)
                        ->first();

                    if ($existingGuest) {
                        session(['guest_user_id' => $existingGuest->id]);
                        Auth::loginUsingId($existingGuest->id);
                    } else {
                        $guest = User::create([
                            'first_name' => 'Guest',
                            'last_name' => 'User',
                            'email' => 'guest_' . uniqid() . '@british.com',
                            'phone' => '000' . rand(1000000, 9999999),
                            'password' => bcrypt($sessionId),
                            'is_guest' => 1,
                            'session' => $sessionId,
                            'language_id' => 1,
                            'is_admin' => 0,
                        ]);

                        session(['guest_user_id' => $guest->id]);
                        Auth::loginUsingId($guest->id);
                    }
                }

                return $next($request);
            });

        }
    }

  /*   protected $firebaseService;
    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }
    public function sendNotification(Request $request)
    {
        $token = $request->input('token');
        $title = $request->input('title');
        $body = $request->input('body');

        $response = $this->firebaseService->sendNotification($token, $title, $body);

        return response()->json($response);
    } */
    public function smartReturn(Request $request, $view, $data)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($data);
        }

        return view($view, $data);
    }


   public function updateTransactionPrices($transaction_id)
    {
        $transaction = Transaction::with('items')->find($transaction_id);

        if (!$transaction) {
            return response()->json(['status' => 'error', 'message' => 'Transaction not found'], 404);
        }

        $newTotal = 0;

        foreach ($transaction->items as $item) {
            $item->total_price = ($item->price_per_unit * $item->quantity) - $item->discount;
            $item->save();

            $newTotal += $item->total_price;
        }

        $transaction->total_price = $newTotal;
        $transaction->save();

        return response()->json([
            'status' => 'success',
            'message' => 'All item prices and transaction total updated.',
            'total_transaction_price' => $transaction->total_price,
        ]);
    }
    public function languages()
    {
        $lang=Language::all();
        return response()->json([
            'status' => 'success',
            'language' => $lang,
        ]);
    }
    public function ChageLang(Request $request)
    {
        $request->validate([
            'language_id' => 'required|exists:languages,id',
        ]);

        $user = Auth::user();
        $user->update([
            'language_id' => $request->language_id
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Language changed successfully',
        ]);
    }


    public function UserProfile()
    {
        $user = User::with(['subcity.city', 'language'])->find(Auth::id());


        return response()->json([
            'status' => 'success',
            'data' => $user,
        ]);
    }

        public function EditUser(Request $request)
        {
            $user = Auth::user();

            $validator = Validator::make($request->all(), [
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20|unique:users,phone,' . $user->id,
                //'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
                'language_id' => 'nullable|exists:languages,id',
                'password' => 'nullable|string|min:8|confirmed',
                'subcity_id' => 'nullable|exists:subcities,id',
                'image_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'image_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'subcity_id' => 'nullable',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user->update($request->only([
                'first_name',
                'last_name',
                'phone',
                'email',
                'language_id',
                'subcity_id',
            ]));

            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully',
                'user' => $user,
            ]);
        }

    public function EditUserSubCity(Request $request)
    {

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'subcity_id' => 'required|exists:subcities,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user->subcity_id = $request->subcity_id;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User subcity updated successfully',
            'user' => $user,
        ]);
    }

    public function MainSlider()
    {
        $sliders = Slider::join('slider_langs', 'sliders.id', '=', 'slider_langs.slider_id')
            ->select('slider_langs.title', 'slider_langs.description', 'slider_langs.image')
            ->where('slider_langs.language_id', Auth::user()->language_id)
            ->where('sliders.status', 1)
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $sliders,
        ]);
    }
    public function ProductsCategory()
    {
       $category=ProductCategory::join('product_category_langs', 'product_categories.id', '=', 'product_category_langs.product_category_id')
            ->select('product_categories.id','product_category_langs.name','product_categories.image', 'product_category_langs.description')
            ->where('product_category_langs.language_id', Auth::user()->language_id)
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $category,
        ]);
    }

    public function TopProducts()
    {
        $languageId = Auth::user()->language_id;

        $products = Product::with([
                'langs' => fn($q) => $q->where('language_id', $languageId),
                'category.langs' => fn($q) => $q->where('language_id', $languageId),
                'activePrice.currency',
                'images',
            ])
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->limit(6)
            ->get();

            $products=$products->transform(function ($product) {
                return[
                    'id'=>$product->id,
                    'name' => $product->langs->first()->name ?? '',
                    'price' => $product->activePrice->price ?? 0,
                    'image' => $product->images->pluck('image')->toArray(),
                    'currency_symbol' => $product->activePrice?->currency->symbol ?? '',
                ];
            });
        return response()->json([
            'status' => 'success',
            'data' => $products,
        ]);
    }

    public function Brand()
    {
        $brands = Brand::join('brand_langs', 'brands.id', '=', 'brand_langs.brand_id')
            ->select('brands.id','brand_langs.name','brands.logo')
            ->where('brand_langs.language_id', Auth::user()->language_id)
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $brands,
        ]);
    }

    public function Goal()
    {
        $goals = Goal::join('goal_langs', 'goals.id', '=', 'goal_langs.goal_id')
            ->select('goals.id','goal_langs.name')
            ->where('goal_langs.language_id', Auth::user()->language_id)
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $goals,
        ]);
    }

    public function Tag()
    {
        $tags = Tag::join('tag_langs', 'tags.id', '=', 'tag_langs.tag_id')
            ->select('tags.id','tag_langs.name')
            ->where('tag_langs.language_id', Auth::user()->language_id)
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $tags,
        ]);
    }

    public function News()
    {
        $news = News::join('news_langs', 'news.id', '=', 'news_langs.news_id')
            ->join('news_categories', 'news.news_category_id', '=', 'news_categories.id')
            ->join('news_category_langs', 'news_categories.id', '=', 'news_category_langs.news_category_id')
            ->select('news_langs.title', 'news_langs.description', 'news_langs.image', 'news.seen','news_categories.image','news_category_langs.name', 'news.seen','news_category_langs.description')
            ->where('news_langs.language_id', Auth::user()->language_id)
            ->limit(3)
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $news,
        ]);
    }

    public function Videos()
    {
        $videos=Video::join('video_langs', 'videos.id','=', 'video_langs.video_id')
        ->join('video_categories', 'videos.video_category_id', '=', 'video_categories.id')
        ->join('video_category_langs', 'video_categories.id', '=', 'video_category_langs.video_category_id')
        ->select('video_langs.youtube_code','video_langs.title', 'video_langs.description', 'video_langs.image','videos.seen','video_categories.image','video_category_langs.name','videos.is_live')
        ->where('video_langs.language_id', Auth::user()->language_id)
        ->limit(3)
        ->get();
        return response()->json([
           'status' =>'success',
            'data' => $videos,
        ]);
    }
    public function OneProduct($id)
    {
        $langId = Auth::user()->language_id ?? 1;

        $product = Product::with([
            'langs' => fn($q) => $q->where('language_id', $langId),
            'category.langs' => fn($q) => $q->where('language_id', $langId),
            'brand.langs' => fn($q) => $q->where('language_id', $langId),
            'tags.langs' => fn($q) => $q->where('language_id', $langId),
            'goals.langs' => fn($q) => $q->where('language_id', $langId),
            'tastes.langs' => fn($q) => $q->where('language_id', $langId),
            'images',
            'price.currency',
        ])
        ->where('status', 1)
        ->where('id', $id)
        ->first();

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => new SingleProductResource($product),
        ]);
    }

    public function allProducts(Request $request)
    {
        $languageId = Auth::user()->language_id;

        $products = Product::with([
                'langs' => fn($q) => $q->where('language_id', $languageId),
                'category.langs' => fn($q) => $q->where('language_id', $languageId),
                'activePrice.currency',
                'images',
            ])
            ->where('status', 1)
            ->when($request->category_id, function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })
            ->when($request->name, function ($query) use ($request, $languageId) {
                $query->whereHas('langs', function ($q) use ($request, $languageId) {
                    $q->where('language_id', $languageId)
                      ->where('name', 'like', '%' . $request->name . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

            $products=$products->getCollection()->transform(function ($product) {
                return[
                    'id'=>$product->id,
                    'name' => $product->langs->first()->name ?? '',
                    'price' => $product->activePrice->price ?? 0,
                    'image' => $product->images->pluck('image')->toArray(),
                    'currency_symbol' => $product->activePrice?->currency->symbol ?? '',
                ];
            });


            $data=[
                'status' => 'success',
                'data' => $products,
            ];
          return $this->smartReturn($request, 'welcome', compact('data'));
    }

   public function GetCart()
    {
        $languageId = Auth::user()->language_id ?? 1;

        $cart = Transaction::with([
            'items:id,transaction_id,product_id,taste_id,currency_id,quantity,price_per_unit,total_price',
            'items.product:id',
            'items.taste:id',
            'items.currency:id,name'
        ])
        ->where('transaction_type_id', 1)
        ->where('user_id', Auth::id())
        ->select('id', 'total_price', 'created_at')
        ->latest()
        ->first();

        if (!$cart) {
            return response()->json(['message' => 'No cart found']);
        }

        return response()->json([
            'id' => $cart->id,
            'total_price' => $cart->total_price,
            'created_at' => $cart->created_at,
            'items' => $cart->items->map(function ($item) use ($languageId) {
                return [
                    'item_id' => $item->id,
                    'product_id' => $item->product_id,
                    'taste_id' => $item->taste_id,
                    'product_name' => $item->product?->lang($languageId)?->name,
                    'product_image' => $item->product?->images->first()?->image,
                    'taste_name' => $item->taste?->lang($languageId)?->name,
                    'currency_name' => $item->currency?->name,
                    'quantity' => (int) $item->quantity,
                    'price_per_unit' => (float) $item->price_per_unit,
                    'total_price' => (float) $item->total_price,
                ];
            }),
        ]);
    }

    public function AddToCart($id ,Request $request)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found'], 404);
        }

        $transaction = Transaction::where('user_id', Auth::id())
            ->where('transaction_type_id', 1)
            ->first();

        if (!$transaction) {
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'transaction_type_id' => 1,
            ]);
        }
        $item = TransactionItem::where('transaction_id', $transaction->id)
            ->where('product_id', $id)
            ->where('taste_id', $request->taste_id ?? null)
            ->first();
        if ($item) {
            $item->quantity += $request->quantity ?? 1;
            $item->save();
        } else {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'price_per_unit' => $product->priceIn(1),
                'taste_id' => $request->taste_id ?? null,
                'discount' => 0,
                'total_price' => $product->priceIn(1),
                'buy_price' => $product->buy_price,
                'product_id' => $id,
                'quantity' => $request->quantity ?? 1,
                'currency_id' => 1,
            ]);
        }

        $this->updateTransactionPrices($transaction->id);


        return response()->json(['status' => 'success', 'message' => 'Product added to cart']);
    }
    public function RemoveFromCart($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())
            ->where('transaction_type_id', 1)
            ->first();

        if (!$transaction) {
            return response()->json(['status' => 'error', 'message' => 'Cart not found'], 404);
        }

        $item = TransactionItem::where('id', $id)
            ->first();

        if (!$item) {
            return response()->json(['status' => 'error', 'message' => 'Item not found in cart'], 404);
        }


        $item->delete();


        $this->updateTransactionPrices($transaction->id);

        return response()->json(['status' => 'success', 'message' => 'Product removed from cart']);
    }
    public function UpdateCart($id, $quantity)
    {
        $transaction = Transaction::where('user_id', Auth::id())
            ->where('transaction_type_id', 1)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$transaction) {
            return response()->json(['status' => 'error', 'message' => 'Cart not found'], 404);
        }
        $item = TransactionItem::where('id', $id)
            ->first();

        if (!$item) {
            return response()->json(['status' => 'error', 'message' => 'Item not found in cart'], 404);
        }

        if ($quantity <= 0) {
            $item->delete();
        } else {
            $item->quantity = $quantity;
            $item->save();
        }

        $this->updateTransactionPrices($transaction->id);

        return response()->json(['status' => 'success', 'message' => 'Cart updated successfully']);
    }
    public function Checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //'subcity_id' => 'required|string|max:255',
            //'payment_method' => 'required|string|in:cash,credit_card',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 422);
        }


        $transaction = Transaction::where('user_id', Auth::id())
            ->where('transaction_type_id', 1)
            ->where('id',$request->transaction_id)
            ->first();

        if (!$transaction || $transaction->items->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'Cart is empty'], 400);
        }

        $officeId=OfficeSubcity::where('subcity_id', Auth::user()->subcity_id)
            ->value('office_id');
       // $transaction->transaction_type_id = 2;
        $transaction->address = $request->address;
        $transaction->office_id = $officeId;
        $transaction->order_note = $request->note ?? '';
       // $transaction->subcity_id = $request->subcity_id;
        $transaction->transaction_date = now();
        $transaction->save();

        return response()->json(['status' => 'success', 'message' => 'Checkout successful']);
    }
    public function Search(Request $request)
    {
        $searchTerm = $request->input('query');

        if (!$searchTerm) {
            return response()->json([
                'status' => 'error',
                'message' => 'Query is required',
            ], 400);
        }

        $languageId = Auth::user()->language_id;

        $products = Product::with(['langs' => function ($q) use ($languageId) {
                $q->where('language_id', $languageId);
            }])
            ->where('status', 1)
            ->whereHas('langs', function ($q) use ($searchTerm, $languageId) {
                $q->where('language_id', $languageId)
                ->where('name', 'like', '%' . $searchTerm . '%');
            })
            ->paginate(12);

        return response()->json([
            'status' => 'success',
            'data' => $products,
        ]);
    }



    public function Cities()
    {
        $cities = City::join('city_langs', 'cities.id', '=', 'city_langs.city_id')
            ->select('cities.id','city_langs.name')
            ->where('city_langs.lang_id', Auth::user()->language_id)
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $cities,
        ]);
    }
    public function SubCities()
    {
        $subcities = Subcity::join('subcity_langs', 'subcities.id', '=', 'subcity_langs.subcity_id')
            ->select('subcities.id','subcity_langs.name', 'subcities.city_id')
            ->where('subcity_langs.langid', Auth::user()->language_id)
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $subcities,
        ]);
    }
    public function SubCitiesByCityId($id)
    {
        $subcities = Subcity::join('subcity_langs', 'subcities.id', '=', 'subcity_langs.subcity_id')
            ->select('subcities.id','subcity_langs.name', 'subcities.city_id')
            ->where('subcity_langs.langid', Auth::user()->language_id)
            ->where('subcities.city_id', $id)
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $subcities,
        ]);
    }

     //offices
    public function Offices()
    {
        $offices = Office::with(['subcities.langs' => function ($query) {
            $query->where('langid', Auth::user()->language_id);
        }])->get();

        return response()->json([
            'status' => 'success',
            'data' => $offices,
        ]);
    }

    public function OfficeSubCities()
    {
        $officeSubcities = OfficeSubcity::with(['office.langs' => function ($query) {
            $query->where('langid', Auth::user()->language_id);
        }, 'subcity.langs' => function ($query) {
            $query->where('langid', Auth::user()->language_id);
        }])->get();

        return response()->json([
            'status' => 'success',
            'data' => $officeSubcities,
        ]);
    }
    public function OfficeSubCitiesByOfficeId($officeId)
    {
        $officeSubcities = OfficeSubcity::with(['subcity.langs' => function ($query) {
            $query->where('langid', Auth::user()->language_id);
        }])->where('office_id', $officeId)->get();

        return response()->json([
            'status' => 'success',
            'data' => $officeSubcities,
        ]);
    }
    public function OfficeSubCitiesBySubCityId($subcityId)
    {
        $officeSubcities = OfficeSubcity::with(['office.langs' => function ($query) {
            $query->where('langid', Auth::user()->language_id);
        }])->where('subcity_id', $subcityId)->get();
        return response()->json([
            'status' => 'success',
            'data' => $officeSubcities,
        ]);
    }

    public function selectPaymentMethod(Request $request)
    {
        // Validate input
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        // Get the transaction
        $transaction = Transaction::find($request->transaction_id);

        // Check transaction type
        if ($transaction->transaction_type_id != 1) {
            return response()->json([
                'error' => 'Invalid transaction type'
            ], 400);
        }

        // Update payment method
        $transaction->payment_method = $request->payment_method_id;
        $transaction->save();

        return response()->json([
            'message' => 'Payment method selected successfully',
            'transaction' => $transaction
        ]);
    }

    public function GetPaymentMethod()
    {
        $methods = PaymentMethod::all();
        return response()->json([
            'payment_methods' => $methods
        ]);
    }




}
