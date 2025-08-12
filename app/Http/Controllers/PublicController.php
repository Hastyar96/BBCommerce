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

class PublicController extends Controller
{
    public function __construct(Request $request)
    {

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

        public function Home()
        {
            $sliders = Slider::with('langs')->get();
            $categories = ProductCategory::with('langs')->get();
            $languageId = Auth::user()->language_id;

           $brands = Brand::all();
           $goals = Goal::with('langs')->limit(3)->get();
            return view('website_commerce.home.home', [
                'sliders' => $sliders,
                'categories' => $categories,
                'goals'=>$goals,
                'brands' => $brands,
                'languageId' => $languageId,
            ]);
        }

        public function changeLang($id)
        {
            $user = auth()->user();
            if ($user) {
                $user->language_id = $id;
                $user->save();
                return  redirect()->back();
            }
        }


 public function Products(Request $request)
    {
        $languageId = Auth::user()->language_id;

        // Load related data
        $categories = ProductCategory::with('langs')->get();
        $tags = Tag::with('langs')->get();
        $goals = Goal::with('langs')->get();
        $brands = Brand::all();

        // Build the product query
        $query = Product::with([
            'langs' => fn($q) => $q->where('language_id', $languageId),
            'category.langs' => fn($q) => $q->where('language_id', $languageId),
            'activePrice.currency',
            'images',
            'brand.langs' => fn($q) => $q->where('language_id', $languageId), // Added to support brand name in the correct language
        ])
        ->where('status', 1);

        // Filter by category
        $query->when($request->category_id, fn($q) =>
            $q->where('category_id', $request->category_id)
        );

        // Filter by brand
        $query->when($request->brand_id, fn($q) =>
            $q->where('brand_id', $request->brand_id)
        );

        // Filter by tag
        $query->when($request->tag_id, fn($q) =>
            $q->whereHas('tags', fn($q) =>
                $q->where('tag_id', $request->tag_id)
            )
        );

        // Filter by goal
        $query->when($request->goal_id, fn($q) =>
            $q->whereHas('goals', fn($q) =>
                $q->where('goal_id', $request->goal_id)
            )
        );

        // Filter by search
        $query->when($request->search, fn($q) =>
            $q->whereHas('langs', fn($q2) =>
                $q2->where('name', 'like', '%' . $request->search . '%')
            )
        );

        // Paginate with 12 products per page
        $products = $query->paginate(12);

        // Transform the paginated results
        $products->getCollection()->transform(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->langs->first()->name ?? '',
                'price' => $product->activePrice->price ?? 0,
                'image' => $product->images->pluck('image')->toArray(),
                'currency_symbol' => $product->activePrice?->currency->symbol ?? '',
                'category' => $product->category->langs->first()->name ?? '',
                'brand' => $product->brand->langs->first()->name ?? '',
                'best_sale' => $product->best_sale,
            ];
        });

        return view('website_commerce.products.products', [
            'categories' => $categories,
            'tags' => $tags,
            'goals' => $goals,
            'products' => $products,
            'brands' => $brands,
        ]);
    }


        public function oneProduct($product_id)
        {
            $languageId = Auth::user()->language_id;

            $product = Product::with([
            'langs' => fn($q) => $q->where('language_id', $languageId),
            'category.langs' => fn($q) => $q->where('language_id', $languageId),
            'activePrice.currency',
            'images',
            'tags.langs' => fn($q) => $q->where('language_id', $languageId),
            'goals.langs' => fn($q) => $q->where('language_id', $languageId),
            'brand.langs' => fn($q) => $q->where('language_id', $languageId),
            ])
            ->where('id', $product_id)
            ->where('status', 1)
            ->firstOrFail();

            $productData = [
            'id' => $product->id,
            'name' => $product->langs->first()->name ?? '',
            'serving_g' => $product->serving_g,
            'description' => $product->langs->first()->description ?? '',
            'suited_for' => $product->langs->first()->suited_for ?? '',
            'recommended_use' => $product->langs->first()->recommended_use ?? '',
            'price' => $product->activePrice->price ?? 0,
            'currency_symbol' => $product->activePrice?->currency->symbol ?? '',
            'images' => $product->images->pluck('image')->toArray(),
            'category' => $product->category->langs->first()->name ?? '',
            'brand' => $product->brand->langs->first()->name ?? '',
            'tags' => $product->tags->map(fn($tag) => $tag->langs->first()->name ?? '')->toArray(),
            'goals' => $product->goals->map(fn($goal) => $goal->langs->first()->name ?? '')->toArray(),
            ];

            return view('website_commerce.products.one_product', [
            'product' => $productData,
            ]);
        }


        public function Contact()
        {
        return view('website_commerce.contact.contact');
        }

        public function About()
        {
        return view('website_commerce.about.about');
        }

}
