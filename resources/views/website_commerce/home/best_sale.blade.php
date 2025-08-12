@php
    $languageId = Auth::user()->language_id;
     $best_sales = App\Models\Product::with([
                'langs' => fn($q) => $q->where('language_id', $languageId),
                'category.langs' => fn($q) => $q->where('language_id', $languageId),
                'activePrice.currency',
                'images',
            ])
            ->where('status', 1)
            ->where('best_sale',1)
            ->orderBy('id', 'desc')
            ->limit(4)
            ->get();

            $best_sales=$best_sales->transform(function ($product) {
                return[
                    'id'=>$product->id,
                    'name' => $product->langs->first()->name ?? '',
                    'price' => $product->activePrice->price ?? 0,
                    'image' => $product->images->pluck('image')->toArray(),
                    'currency_symbol' => $product->activePrice?->currency->symbol ?? '',
                ];
            });
@endphp
<!-- Mega Sale Section -->
<section class="mega-sale-section">
    <h2 class="section-title">{{ __('f.best_sellers') }}</h2>
    <div class="top-deals-section">
        <div class="top-deals-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h4 class="top-deals-title">{{ __('f.best_selling_products') }}</h4>
         <a href="{{ url('products') }}" sty class="see-all-btn">{{ __('f.view_all') }}</a>
        </div>

        <hr class="product-divider">

        <div class="product-row">
            @foreach ($best_sales as $product)
            <div class="product-card1">
                <div class="mega-offer">{{ __('f.best_sellers') }}</div>
                <a class="m-0 p-0" href="{{ url('/product/' . $product['id']) }}">
                    <img src="{{ asset($product['image'][0] ?? 'img/no-image.png') }}" alt="{{ $product['name'] }}">
                </a>
                <p class="m-0 p-0"><em>{{ $product['name'] }}</em></p>
                <div class="star-rating m-0 p-0">★★★★☆</div>
                <p class="m-0 p-0"><strong>{{ $product['currency_symbol'] }} {{ number_format($product['price'], 0) }}</strong></p>
                <button class="add-to-cart1 m-0 mt-2 mb-2"
                    onclick="addToCart('{{ $product['name'] }}', {{ $product['price'] }}, '{{ asset($product['image'][0] ?? 'img/no-image.png') }}')">
                    <i class="fas fa-shopping-cart"></i>
                </button>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    /* Mega Sale Section */
    .mega-sale-section {
        max-width: 1200px;
        margin: 60px auto;
    }

    .top-deals-section {
        background-color: #fff;
        border: 2px solid #ddd;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .top-deals-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .top-deals-title {
        font-size: 24px;
        font-weight: bold;
        color: #2c3e50;
    }

    .view-all-btn {
        background-color: #2c3e50;
        color: white;
        padding: 8px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .view-all-btn:hover {
        background-color: #e74c3c;
    }

    .product-divider {
        margin: 20px 0;
        border-top: 1px solid #ccc;
    }

    .product-row {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: nowrap;
    }

    .product-card1 {
        flex: 1;
        max-width: 25%;
        border: 1px solid #eee;
        border-radius: 10px;
        text-align: center;
        background-color: #fff;
        position: relative;
        transition: transform 0.3s;
    }

    .product-card1:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .product-card1 img {
        width: 150px;
        height: auto;
    }

    .mega-offer {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #e74c3c;
        color: white;
        padding: 4px 8px;
        font-size: 11px;
        font-weight: bold;
        border-radius: 5px;
    }

    .star-rating {
        color: #ffc107;
        font-size: 16px;
        margin: 8px 0;
    }

    .add-to-cart1 {
        width: 65px;
        height: 30px;
        background-color: #2c3e50;
        color: #fff;
        border: none;
        padding: 4px ;
        margin-top: 10px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .add-to-cart1:hover {
        background-color: #e74c3c;
    }

    /* Responsive Styles for Mega Sale Section */
    @media (max-width: 768px) {
        .product-row {
            flex-wrap: wrap;
            gap: 30px;
        }

        .product-card1 {
            margin-bottom: 20px;
            padding: 12px;
        }

        .product-card1 img {
            width: 100px;
            height: 100px;
        }

        .add-to-cart1 {
            width: 55px;
            height: 28px;
            font-size: 14px;
        }
    }

    @media (max-width: 480px) {
        .product-card1 {
            max-width: 100%;
        }

        .product-card1 img {
            width: 80px;
        }
    }

</style>
