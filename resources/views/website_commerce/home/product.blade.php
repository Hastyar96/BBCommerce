@php
   $languageId = Auth::user()->language_id;
              $products = App\Models\Product::with([
                'langs' => fn($q) => $q->where('language_id', $languageId),
                'category.langs' => fn($q) => $q->where('language_id', $languageId),
                'activePrice.currency',
                'images',
            ])
            ->where('status', 1)
            ->inRandomOrder()
            ->limit(6)
            ->get();

            $products=$products->transform(function ($product) {
                return[
                    'id'=>$product->id,
                    'name' => $product->langs->first()->name ?? '',
                    'price' => $product->activePrice->price ?? 0,
                    'image' => $product->images->pluck('image')->toArray(),
                    'currency_symbol' => $product->activePrice?->currency->symbol ?? '',
                    'category' => $product->category->langs->first()->name ?? '',
                    'brand' => $product->brand->langs->first()->name ?? '',
                ];
            });
@endphp
<!-- Products Slider Section -->
<section class="products-slider container">
    <!-- Header with title and navigation -->
    <div class="products-header">
        <h2 class="section-title">{{ __('f.shopping') }}</h2>
        <div class="header-controls">
            <a href="{{ url('products') }}" sty class="see-all-btn">{{ __('f.view_all') }}</a>
            <div class="slider-nav">
                <div class="slider-arrow left-arrow" onclick="scrollProducts(-1)">
                    <i class="fas fa-chevron-left"></i>
                </div>
                <div class="slider-arrow right-arrow" onclick="scrollProducts(1)">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Container -->
    <div class="products-container row flex-nowrap overflow-hidden g-3" id="products-container">
        @foreach ($products as $product)
            <div class="product-card col-md-3 col-sm-3 col-6">
                <div class="product-img position-relative ">
                    <a class="d-flex  justify-content-center align-items-center" href="{{ url('/product/' . $product['id']) }}">
                        <img class="m-0 p-0" src="{{ asset($product['image'][0] ?? 'img/default.jpg') }}" alt="{{ $product['name'] }}" class="w-100 rounded">
                    </a>
                    <div class="favorite-icon position-absolute top-0 end-0" onclick="toggleFavorite(this)">
                        <i class="fas fa-heart"></i>
                    </div>
                </div>
                <div class="product-info d-flex  justify-content-between align-items-center">
                    <?php
                        $productName = $product['name'];
                        $maxLength = 14;
                        $displayProductName = mb_strlen($productName, 'UTF-8') > $maxLength
                            ? mb_substr($productName, 0, $maxLength, 'UTF-8') . '...'
                            : $productName;
                    ?>
                    <div class="">
                        <h3 class="product-title">{{ $displayProductName }}</h3>
                        <p class="product-price">{{ $product['currency_symbol'] }}{{ number_format($product['price'], 2) }}</p>
                    </div>
                   <div class="">
                     <button class="add-to-cart" onclick="addToCart('{{ $product['name'] }}', {{ $product['price'] }}, '{{ asset($product['image'][0] ?? 'img/default.jpg') }}')">
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                   </div>
                </div>
            </div>
        @endforeach
    </div>
</section>


    <!-- Products Slider style -->
    <style>
   /* Products Slider Styles */
.products-slider {
    position: relative;
    padding: 20px 0;
}

/* Header Styles */
.products-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
}

.header-controls {
    display: flex;
    align-items: center;
    gap: 15px;
}

.see-all-btn {
    background-color: #2c3e50;
    color: white;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 14px;
    text-decoration: none;
    font-weight: 500;
    transition: background-color 0.3s;
    width: 100px;
    text-align: center;
}

.see-all-btn:hover {
    background-color: #e74c3c;
}

/* Slider Navigation */
.slider-nav {
    display: flex;
    gap: 10px;
}

.slider-arrow {
    position: absolute;
    top: 240px;
    width: 40px;
    height: 40px;
    background-color: #2c3e50;
    color: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 10;
}

.left-arrow {
    left: 0;
}

.right-arrow {
    right: 0;
}

.slider-arrow:hover {
    background-color: #e74c3c;
    transform: scale(1.1);
}

/* Products Container */
.products-container {
    display: flex;
    overflow-x: auto;
    gap: 20px;
    padding-bottom: 20px;
    scroll-behavior: smooth;
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
}

.products-container::-webkit-scrollbar {
    display: none; /* Chrome, Safari, and Opera */
}

/* Product Card */
.product-card {
    min-width: 150px;
    background-color: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s, box-shadow 0.3s;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.product-img {
    position: relative;
}

.product-img img {
    width: 70%;
    display: block;
    margin: 15px 0 0 20px;
}

/* Favorite Icon */
.favorite-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #fff;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: all 0.3s;
}

.favorite-icon i {
    color: #ddd;
    font-size: 16px;
}

.favorite-icon.active i {
    color: #e74c3c;
}

.favorite-icon:hover i {
    color: #e74c3c;
}

/* Product Info */
.product-info {
    padding-bottom: 0px;
}

.product-title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 5px;
    color: #2c3e50;
}

.product-price {
    font-size: 18px;
    font-weight: 700;
    color: #e74c3c;
    margin-bottom: 10px;
}

.add-to-cart {
    width: 100%;
    background-color: #2c3e50;
    color: #fff;
    border: none;
    padding: 8px 13px;
    border-radius: 5px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s;
}

.add-to-cart:hover {
    background-color: #e74c3c;
}
    </style>


<script>
function scrollProducts(direction) {
    const container = document.getElementById('products-container');
    const scrollAmount = 300;
    container.scrollBy({
        left: scrollAmount * direction,
        behavior: 'smooth'
    });
}
</script>
