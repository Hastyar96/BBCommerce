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

class ApiPublicController extends Controller
{
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

    public function UserProfile()
    {
        $user = User::find(Auth::user()->id);
        $lang=Language::where('id',$user->language_id)->first();
        return response()->json([
            'status' => 'success',
            'data' => $user,
            'language' => $lang,
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
            ->select('product_category_langs.name','product_categories.image', 'product_category_langs.description')
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
                'brand.langs' => fn($q) => $q->where('language_id', $languageId),
                'category.langs' => fn($q) => $q->where('language_id', $languageId),
         /*        'goal.langs' => fn($q) => $q->where('language_id', $languageId),
                'tag.langs' => fn($q) => $q->where('language_id', $languageId), */
                'langs' => fn($q) => $q->where('language_id', $languageId),
            ])
            ->where('status', 1)
            ->limit(6)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $products,
        ]);
    }

    public function Brand()
    {
        $brands = Brand::join('brand_langs', 'brands.id', '=', 'brand_langs.brand_id')
            ->select('brand_langs.name','brands.logo')
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
            ->select('goal_langs.name')
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
            ->select('tag_langs.name')
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
        $product = Product::join('product_langs', 'products.id', '=', 'product_langs.product_id')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->join('product_category_langs', 'product_categories.id', '=', 'product_category_langs.product_category_id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->join('brand_langs', 'brands.id', '=', 'brand_langs.brand_id')
            ->join('goals', 'products.goal_id', '=', 'goals.id')
            ->join('goal_langs', 'goals.id', '=', 'goal_langs.goal_id')
            ->join('tags', 'products.tag_id', '=', 'tags.id')
            ->join('tag_langs', 'tags.id', '=', 'tag_langs.tag_id')
            ->join('product_images','product_images.product_id','=','products.id')
            ->select('product_langs.name', 'product_langs.description', 'product_langs.image','product_categories.id as category_id','product_category_langs.name as category_name','brands.id as brand_id','brand_langs.name as brand_name','goals.id as goal_id','goal_langs.name as goal_name','tags.id as tag_id','tag_langs.name as tag_name')
            ->where('product_langs.language_id', Auth::user()->language_id)
            ->where('products.status', 1)
            ->where('products.id',$id)
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $product,
        ]);
    }


}
