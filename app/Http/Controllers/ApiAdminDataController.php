<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Services\FirebaseService;
use Illuminate\Support\Str;

use App\Http\Resources\ProductResource;

use App\Models\User;
use App\Models\Slider;
use App\Models\SliderLang;
use App\Models\ProductCategory;
use App\Models\ProductCategoryLang;
use App\Models\Product;
use App\Models\ProductLang;
use App\Models\Brand;
use App\Models\Goal;
use App\Models\GoalLang;
use App\Models\Tag;
use App\Models\Language;
use App\Models\BrandLang;
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
use App\Models\CityLang;
use App\Models\SubcityLang;
use App\Models\OfficeLang;
use App\Models\Office;
use App\Models\OfficeSubcity;
use App\Models\Taste;
use App\Models\TasteLang;
use App\Models\Taxi;
use App\Models\ProductTaste;
use App\Models\ProductPrice;
use App\Models\ProductImage;

class ApiAdminDataController extends Controller
{
    public function GetCities()
    {
        $cities = City::all();
        return response()->json($cities);
    }

    public function AddCity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $city = City::create($request->all());
        return response()->json($city, 201);
    }

    public function EditCity(Request $request, $id)
    {
        $city = City::findOrFail($id);
        $city->update($request->all());
        return response()->json($city);
    }


    // Other methods for subcities, offices, etc. would follow a similar pattern...

    public function GetCityLangs($city_id)
    {
        $langs = City::findOrFail($city_id)->langs;
        return response()->json($langs);
    }
    public function AddCityLang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city_id' => 'required|exists:cities,id',
            'lang_id' => 'required|string|max:10',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $lang = CityLang::create($request->all());
        return response()->json($lang, 201);
    }
    public function EditCityLang(Request $request, $id)
    {
        $lang = CityLang::findOrFail($id);
        $lang->update($request->all());
        return response()->json($lang);
    }

    public function GetSubcities($city_id)
    {
        $subcities = Subcity::where('city_id', $city_id)->get();
        return response()->json($subcities);
    }
    public function AddSubcity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $subcity = Subcity::create($request->all());
        return response()->json($subcity, 201);
    }
    public function EditSubcity(Request $request, $id)
    {
        $subcity = Subcity::findOrFail($id);
        $subcity->update($request->all());
        return response()->json($subcity);
    }
    public function GetSubcityLangs($subcity_id)
    {
        $langs = Subcity::findOrFail($subcity_id)->langs;
        return response()->json($langs);
    }
    public function AddSubcityLang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subcity_id' => 'required|exists:subcities,id',
            'langid' => 'required|string|max:10',
            'name' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $lang = SubcityLang::create($request->all());
        return response()->json($lang, 201);
    }
    public function EditSubcityLang(Request $request, $id)
    {
        $lang = SubcityLang::findOrFail($id);
        $lang->update($request->all());
        return response()->json($lang);
    }

    public function GetOffices()
    {
        $offices = Office::all();
        return response()->json($offices);
    }
    public function AddOffice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'lat' => 'numeric',
            'long' => 'numeric',

        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $office = Office::create($request->all());
        return response()->json($office, 201);
    }
    public function EditOffice(Request $request, $id)
    {
        $office = Office::findOrFail($id);
        $office->update($request->all());
        return response()->json($office);
    }

    public function GetOfficeSubcities($office_id)
    {
        $subcities = OfficeSubcity::where('office_id', $office_id)
        ->with(['office','subcity.city'])->get();
        return response()->json($subcities);
    }
    public function AddOfficeSubcity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'office_id' => 'required|exists:offices,id',
            'subcity_id' => 'required|exists:subcities,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $officeSubcity = OfficeSubcity::create($request->all());
        return response()->json($officeSubcity, 201);
    }
    public function EditOfficeSubcity(Request $request, $id)
    {
        $officeSubcity = OfficeSubcity::findOrFail($id);
        $officeSubcity->update($request->all());
        return response()->json($officeSubcity);
    }

    public function GetLanguages()
    {
        $languages = Language::all();
        return response()->json($languages);
    }
    public function AddLanguage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:languages,code',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $language = Language::create($request->all());
        return response()->json($language, 201);
    }

    public function EditLanguage(Request $request, $id)
    {
        $language = Language::findOrFail($id);
        $language->update($request->all());
        return response()->json($language);
    }

    public function GetBrands()
    {
        $brands = Brand::all();
        return response()->json($brands);
    }
    public function AddBrand(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'logo' => 'nullable|image|max:2048',
            // add other fields you need like: 'name' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('image/logo'), $imageName);
            $data['logo'] = 'image/logo/' . $imageName;
        }

        $brand = Brand::create($data);

        return response()->json($brand, 201);
    }

    public function EditBrand(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'logo' => 'nullable|image|max:2048',
            // add validation for other fields as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $request->all();

        // Check if a new logo is uploaded
        if ($request->hasFile('logo')) {
            // Optional: Delete old logo file if it exists
            if ($brand->logo && file_exists(public_path($brand->logo))) {
                unlink(public_path($brand->logo));
            }

            $image = $request->file('logo');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('image/logo'), $imageName);
            $data['logo'] = 'image/logo/' . $imageName;
        }

        $brand->update($data);

        return response()->json($brand);
    }



    public function GetBrandLangs($brand_id)
    {
        $langs = Brand::findOrFail($brand_id)->langs;
        return response()->json($langs);
    }
    public function AddBrandLang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_id' => 'required|exists:brands,id',
            'language_id' => 'required|string|max:10',
            'name' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $lang = BrandLang::create($request->all());
        return response()->json($lang, 201);
    }

    public function EditBrandLang(Request $request, $id)
    {
        $lang = BrandLang::findOrFail($id);
        $lang->update($request->all());
        return response()->json($lang);
    }

    public function GetGoals()
    {
        $goals = Goal::all();
        return response()->json($goals);
    }
    public function AddGoal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|max:2048',
            // add other fields you need like: 'name' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $data = $request->all();
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('image/goal'), $imageName);
            $data['image'] = 'image/goal/' . $imageName;
        }
        $goal = Goal::create($data);
        return response()->json($goal, 201);
    }
    public function EditGoal(Request $request, $id)
    {
        $goal = Goal::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|max:2048',
            // add validation for other fields as needed
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $request->all();

        // Check if a new image is uploaded
        if ($request->hasFile('image')) {
            // Optional: Delete old image file if it exists
            if ($goal->image && file_exists(public_path($goal->image))) {
                unlink(public_path($goal->image));
            }

            $image = $request->file('image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('image/goal'), $imageName);
            $data['image'] = 'image/goal/' . $imageName;
        }

        $goal->update($data);

        return response()->json($goal);
    }

    public function GetGoalLangs($goal_id)
    {
        $langs = Goal::findOrFail($goal_id)->langs;
        return response()->json($langs);
    }
    public function AddGoalLang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'goal_id' => 'required|exists:goals,id',
            'language_id' => 'required|string|max:10',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $lang = GoalLang::create($request->all());
        return response()->json($lang, 201);

    }
    public function EditGoalLang(Request $request, $id)
    {
        $lang = GoalLang::findOrFail($id);
        $lang->update($request->all());
        return response()->json($lang);
    }


     public function GetTags()
    {
        $tags = Tag::all();
        return response()->json($tags);
    }

    // ADD a new tag
    public function AddTag(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('image/tag'), $imageName);
            $data['image'] = 'image/tag/' . $imageName;
        }

        $tag = Tag::create($data);
        return response()->json($tag, 201);
    }

    // EDIT an existing tag
    public function EditTag(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($tag->image && file_exists(public_path($tag->image))) {
                unlink(public_path($tag->image));
            }

            $image = $request->file('image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('image/tag'), $imageName);
            $data['image'] = 'image/tag/' . $imageName;
        }

        $tag->update($data);
        return response()->json($tag);
    }

    // GET tag translations
    public function GetTagLangs($tag_id)
    {
        $langs = Tag::findOrFail($tag_id)->langs;
        return response()->json($langs);
    }

    // ADD a new tag translation
    public function AddTagLang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tag_id' => 'required|exists:tags,id',
            'language_id' => 'required|string|max:10',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $lang = TagLang::create($request->all());
        return response()->json($lang, 201);
    }

    // EDIT a tag translation
    public function EditTagLang(Request $request, $id)
    {
        $lang = TagLang::findOrFail($id);
        $lang->update($request->all());
        return response()->json($lang);
    }


    // GET all sliders
    public function GetSliders()
    {
        $sliders = Slider::all();
        return response()->json($sliders);
    }

    // ADD a new slider
    public function AddSlider(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $slider = Slider::create($request->all());
        return response()->json($slider, 201);
    }

    // EDIT a slider
    public function EditSlider(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $slider->update($request->all());
        return response()->json($slider);
    }

    // GET all languages of one slider
    public function GetSliderLangs($slider_id)
    {
        $langs = Slider::findOrFail($slider_id)->langs;
        return response()->json($langs);
    }

    // ADD a language entry
    public function AddSliderLang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slider_id' => 'required|exists:sliders,id',
            'language_id' => 'required|string|max:10',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('image/slider'), $imageName);
            $data['image'] = 'image/slider/' . $imageName;
        }

        $lang = SliderLang::create($data);
        return response()->json($lang, 201);
    }

    // EDIT a slider language
    public function EditSliderLang(Request $request, $id)
    {
        $lang = SliderLang::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'language_id' => 'sometimes|string|max:10',
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($lang->image && file_exists(public_path($lang->image))) {
                unlink(public_path($lang->image));
            }

            $image = $request->file('image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('image/slider'), $imageName);
            $data['image'] = 'image/slider/' . $imageName;
        }

        $lang->update($data);
        return response()->json($lang);
    }

     public function GetProductCategories()
    {
        $categories = ProductCategory::all();
        return response()->json($categories);
    }

    public function AddProductCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $request->all();

        // Image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('image/product-category'), $imageName);
            $data['image'] = 'image/product-category/' . $imageName;
        }

        $category = ProductCategory::create($data);
        return response()->json($category, 201);
    }

    public function EditProductCategory(Request $request, $id)
    {
        $category = ProductCategory::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }

            $image = $request->file('image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('image/product-category'), $imageName);
            $data['image'] = 'image/product-category/' . $imageName;
        }

        $category->update($data);
        return response()->json($category);
    }

    // ==================== PRODUCT CATEGORY LANG ====================

    public function GetProductCategoryLangs($category_id)
    {
        $langs = ProductCategory::findOrFail($category_id)->langs;
        return response()->json($langs);
    }

    public function AddProductCategoryLang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_category_id' => 'required|exists:product_categories,id',
            'language_id' => 'required|string|max:10',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $lang = ProductCategoryLang::create($request->all());
        return response()->json($lang, 201);
    }

    public function EditProductCategoryLang(Request $request, $id)
    {
        $lang = ProductCategoryLang::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'language_id' => 'sometimes|string|max:10',
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $lang->update($request->all());
        return response()->json($lang);
    }


      // ==================== TASTE ====================

    public function GetTastes()
    {
        $tastes = Taste::all();
        return response()->json($tastes);
    }

    public function AddTaste(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $taste = Taste::create($request->all());
        return response()->json($taste, 201);
    }

    public function EditTaste(Request $request, $id)
    {
        $taste = Taste::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $taste->update($request->all());
        return response()->json($taste);
    }

    // ==================== TASTE LANG ====================

    public function GetTasteLangs($taste_id)
    {
        $langs = Taste::findOrFail($taste_id)->translations;
        return response()->json($langs);
    }

    public function AddTasteLang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'taste_id' => 'required|exists:tastes,id',
            'language_id' => 'required|string|max:10',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $lang = TasteLang::create($request->all());
        return response()->json($lang, 201);
    }

    public function EditTasteLang(Request $request, $id)
    {
        $lang = TasteLang::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'language_id' => 'sometimes|string|max:10',
            'name' => 'sometimes|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $lang->update($request->all());
        return response()->json($lang);
    }

    // ==================== TAXI ====================

    // Get all taxis
    public function GetTaxis()
    {
        $taxis = Taxi::all();
        return response()->json($taxis);
    }

    // Add a new taxi
    public function AddTaxi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'office_id' => 'required|exists:offices,id',
            'tablo' => 'nullable|string|max:255',
            'xawan_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $taxi = Taxi::create($request->all());
        return response()->json($taxi, 201);
    }

    // Edit an existing taxi
    public function EditTaxi(Request $request, $id)
    {
        $taxi = Taxi::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'office_id' => 'sometimes|exists:offices,id',
            'tablo' => 'nullable|string|max:255',
            'xawan_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $taxi->update($request->all());
        return response()->json($taxi);
    }

    public function GetProducts()
    {
        $products = Product::with([
            'langs.language',
            'images',
            'activePrice.currency',
            'tags.langs.language',
            'goals.langs.language',
            'tastes.langs.language',
            'brand',
            'category',
        ])
        ->orderBy('created_at', 'desc')
        ->get();

        return ProductResource::collection($products);
    }

    public function GetProduct($id)
    {
        $product = Product::with([
            'langs.language',
            'images',
            'activePrice.currency',
            'tags.langs.language',
            'goals.langs.language',
            'tastes.langs.language',
            'brand',
            'category',
        ])->findOrFail($id);

        return new ProductResource($product);
    }

    public function AddProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'nullable|exists:product_categories,id',
            //'size_type' => 'required|in:1,2,3',
            //'size' => 'nullable|json',
            'status' => 'nullable|boolean',
            'for_gift' => 'nullable|boolean',
            'for_sell' => 'nullable|boolean',
            'for_buy' => 'nullable|boolean',
            'buy_price' => 'nullable|numeric',
            'note' => 'nullable|string|max:1000',
            'serving_g' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $request->except(['tags', 'goals', 'tastes', 'langs', 'prices', 'images','tastes']);
        $product = Product::create($data);

        // ========== Relationships ==========

        // Tags
        if ($request->has('tags')) {
            $product->tags()->sync($request->input('tags'));
        }

        // Goals
        if ($request->has('goals')) {
            $product->goals()->sync($request->input('goals'));
        }

        // Tastes
        if ($request->has('tastes')) {
            foreach ($request->input('tastes') as $tasteId) {
                 ProductTaste::create([
                    'product_id' => $product->id,
                    'taste_id' => $tasteId,
                ]);
            }
        }

        // Langs
        if ($request->has('langs')) {
            foreach ($request->input('langs') as $lang) {
                ProductLang::create([
                    'product_id' => $product->id,
                    'language_id' => $lang['language_id'],
                    'name' => $lang['name'], // Error occurs here if 'name' is missing
                    'description' => $lang['description'] ?? '',
                    'suited_for' => $lang['suited_for'],
                    'recommended_use' => $lang['recommended_use'],
                ]);
            }
        }

        // Prices
        if ($request->has('prices')) {
            foreach ($request->input('prices') as $price) {
                 ProductPrice::create([
                    'product_id' => $product->id,
                    'price' => $price['price'],
                    'currency_id' => $price['currency_id'],
                    'is_active' => $price['is_active'] ?? 0,
                    //'office_ids' => json_encode($price['office_ids']),
                ]);
            }
        }

        // Images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $imageName = Str::random(20) . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('image/product'), $imageName);

                 ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'image/product/' . $imageName,
                ]);
            }
        }

        return response()->json($product->load(['langs', 'images', 'tags', 'goals', 'price','tastes']), 201);
    }

   public function EditProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'nullable|exists:product_categories,id',
            'status' => 'nullable|boolean',
            'for_gift' => 'nullable|boolean',
            'for_sell' => 'nullable|boolean',
            'for_buy' => 'nullable|boolean',
            'buy_price' => 'nullable|numeric',
            'note' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $product->update($request->except(['tags', 'goals', 'tastes', 'langs', 'prices', 'images']));

        // ========== Tags ==========
        if ($request->has('tags')) {
            $product->tags()->sync($request->input('tags'));
        }

        // ========== Goals ==========
        if ($request->has('goals')) {
            $product->goals()->sync($request->input('goals'));
        }

        // ========== Tastes ==========
        if ($request->has('tastes')) {
              ProductTaste::where('product_id', $product->id)->delete();
            foreach ($request->input('tastes') as $tasteId) {
                ProductTaste::create([
                    'product_id' => $product->id,
                    'taste_id' => $tasteId,
                ]);
            }
        }

        // ========== Langs ==========
        if ($request->has('langs')) {
            foreach ($request->input('langs') as $lang) {
                ProductLang::updateOrCreate(
                    // Condition (find by product + language)
                    [
                        'product_id'   => $product->id,
                        'language_id'  => $lang['language_id'],
                    ],
                    // Values to update or insert
                    [
                        'name'             => $lang['name'],
                        'description'      => $lang['description'] ?? '',
                        'suited_for'       => $lang['suited_for'],
                        'recommended_use'  => $lang['recommended_use'],
                    ]
                );
            }
        }


        // ========== Prices ==========
        if ($request->has('prices')) {
            foreach ($request->input('prices') as $price) {
                 ProductPrice::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'currency_id' => $price['currency_id'],
                    ],
                    [
                        'price' => $price['price'],
                        'is_active' => $price['is_active'] ?? 0,
                       // 'office_ids' => json_encode($price['office_ids']),
                    ]
                );
            }
        }

        // ========== Images ==========
        if ($request->hasFile('images')) {
            // Optional: delete old images
            ProductImage::where('product_id', $product->id)->delete();

            foreach ($request->file('images') as $imageFile) {
                $imageName = Str::random(20) . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('image/product'), $imageName);

                \App\Models\ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'image/product/' . $imageName,
                ]);
            }
        }

        return response()->json($product->load(['langs', 'images', 'tags', 'goals', 'price', 'tastes']), 200);
    }



    public function GetUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Get a single user by ID.
     */
    public function GetUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user);
    }

    /**
     * Add a new user.
     */
    public function AddUser(Request $request)
    {
        // Validate the incoming request data.
        $request->validate([
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'phone'       => 'required|string|max:255|unique:users,phone',
            // Uncomment email validation if needed:
            // 'email'       => 'nullable|email|max:255|unique:users,email',
            'password'    => 'required|string|min:6',
            // Include any other fields as needed:
            'role_id'     => 'nullable|integer',
            'language_id' => 'nullable|integer',
            'office_id'   => 'nullable|integer',
        ]);

        // Create new user data array.
        $data = $request->only([
            'first_name',
            'last_name',
            'phone',
            'email',
            'role_id',
            'language_id',
            'office_id'
        ]);

        // Hash the password.
        $data['password'] = Hash::make($request->password);

        // Optionally, if your model has additional attributes like verification
        // codes, is_admin flags etc., set them here or rely on defaults.

        $user = User::create($data);

        return response()->json($user, 201);
    }

    /**
     * Edit an existing user.
     */
    public function EditUser(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Validate the data. Use "sometimes" for optional fields.
        $request->validate([
            'first_name'  => 'sometimes|required|string|max:255',
            'last_name'   => 'sometimes|required|string|max:255',
            'phone'       => 'sometimes|required|string|max:255|unique:users,phone,' . $user->id,
            // 'email'       => 'sometimes|nullable|email|max:255|unique:users,email,' . $user->id,

            'role_id'     => 'sometimes|nullable|integer',
            'language_id' => 'sometimes|nullable|integer',
            'office_id'   => 'sometimes|nullable|integer',
            'is_admin'  => 'sometimes|boolean',
        ]);

        // Prepare data to update.
        $updateData = $request->only([
            'first_name',
            'last_name',
            'phone',
            'email',
            'role_id',
            'language_id',
            'office_id',
            'is_admin',
        ]);


        // Update the user.
        $user->update($updateData);

        return response()->json($user);
    }

    /**
     * Delete an existing user.
     */
    public function DeleteUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }



}
