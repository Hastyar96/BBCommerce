@include('website_commerce.header')

<div class="container py-5">
    <div class="product-container">
        <!-- Heart Icon -->
        <div class="heart-icon" id="favoriteHeart">
            <i class="far fa-heart"></i>
        </div>

        <!-- Product Header -->
        <div class="product-header">
            <!-- Product Image Gallery -->
            <div class="product-gallery">
                <div class="main-image-container">
                    <img src="{{ asset($product['images'][0] ?? 'img/no-image.png') }}" alt="{{ $product['name'] }}"
                        class="main-image" id="mainImage">
                </div>
                <div class="thumbnail-container">
                    @foreach($product['images'] as $image)
                    <div class="thumbnail-item">
                        <img src="{{ asset($image) }}" alt="{{ __('f.thumbnail_alt') }}" class="thumbnail"
                            onclick="changeMainImage(this)">
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="product-details">
                <div class="product-meta">
                    <span class="product-brand">{{ $product['brand'] }}</span>
                    <!-- <span class="product-sku">{{ __('f.sku') }}: {{ $product['sku'] ?? 'N/A' }}</span> -->
                </div>

                <h1 class="product-title">{{ $product['name'] }}</h1>
                <!--
                <div class="rating-container">
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <div class="rating-links">
                        <a href="#reviews" class="review-count">{{ __('f.reviews_count') }}</a>
                        <span class="divider">|</span>
                        <a href="#write-review">{{ __('f.write_review') }}</a>
                    </div>
                </div>
                -->
                <div class="availability">
                    <i class="fas fa-check-circle"></i> {{ __('f.in_stock') }}
                </div>

                <div class="price-container">
                    <div class="price-info">
                        <span
                            class="price-new">{{ $product['currency_symbol'] }}{{ number_format($product['price']) }}</span>
                        <span class="price-old">{{ __('f.price_old') }}</span>
                    </div>
                    <span class="discount-badge">{{ __('f.discount_badge') }}</span>
                </div>

                <!-- Tags Section -->
                @if(!empty($product['tags']))
                <div class="tags-section">
                    <h4>{{ __('f.product_tags') }}</h4>
                    <div class="tags-container">
                        @foreach($product['tags'] as $tag)
                        <span class="product-tag">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="product-highlights">
                    <div class="highlight-item">
                        <i class="fas fa-check-circle"></i> {{ __('f.free_shipping') }}
                    </div>
                </div>

                <div class="quantity-selector">
                    <label for="quantity">{{ __('f.quantity_label') }}</label>
                    <div class="quantity-controls">
                        <button class="quantity-btn minus">-</button>
                        <input readonly type="number" id="quantity" value="1" min="1" max="10">
                        <button class="quantity-btn plus">+</button>
                    </div>
                </div>

                <div class="action-buttons">
                    <button class="btn-primary add-to-cart" data-name="{{ $product['name'] }}"
                        data-price="{{ $product['price'] }}"
                        data-image="{{ asset($product['images'][0] ?? 'img/no-image.png') }}"
                        onclick="addToCartFromData(this)">
                        <i class="fas fa-shopping-cart"></i> {{ __('f.add_to_cart') }}
                    </button>
                    <button class="btn-secondary buy-now">
                        <i class="fas fa-bolt"></i> {{ __('f.buy_now') }}
                    </button>
                </div>

                <div class="social-sharing">
                    <span>{{ __('f.share') }}</span>
                    <a href="#" class="share-btn facebook" onclick="shareOnFacebook(event)" title="Share on Facebook"><i
                            class="fab fa-facebook-f"></i></a>
                    <a href="#" class="share-btn instagram" onclick="shareOnInstagram(event)"
                        title="Share on Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="share-btn whatsapp" onclick="shareOnWhatsApp(event)" title="Share on WhatsApp"><i
                            class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>

        <!-- Product Tabs -->
        <div class="product-tabs">
            <ul class="tabs-nav">
                <li class="active"><a href="#description">{{ __('f.description_tab') }}</a></li>
                <!--
                <li><a href="#specifications">{{ __('f.specifications_tab') }}</a></li>
                <li><a href="#reviews">{{ __('f.reviews_tab') }}</a></li>
                <li><a href="#shipping">{{ __('f.shipping_tab') }}</a></li>
                -->
            </ul>

            <div class="tabs-content">
                <div id="description" class="tab-pane active">
                    <h3>{{ __('f.product_details') }}</h3>
                    {!! preg_replace('/#([0-9A-Fa-f]{2})([0-9A-Fa-f]{6})/i', '#$2', $product['description']) !!}

                    <!-- Goals Section -->
                    @if(!empty($product['goals']))
                    <div class="specs-section">
                        <h4>{{ __('f.goals') }}</h4>
                        <ul class="specs-list">
                            @foreach($product['goals'] as $goal)
                            <li>{{ $goal }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Suited For Section -->
                    @if(!empty($product['suited_for']))
                    <div class="specs-section">
                        <h4>{{ __('f.suited_for') }}</h4>
                        {!! preg_replace('/#([0-9A-Fa-f]{2})([0-9A-Fa-f]{6})/i', '#$2', $product['suited_for']) !!}
                    </div>
                    @endif

                    <!-- Recommended Use Section -->
                    @if(!empty($product['recommended_use']))
                    <div class="specs-section">
                        <h4>{{ __('f.recommended_use') }}</h4>
                        {!! preg_replace('/#([0-9A-Fa-f]{2})([0-9A-Fa-f]{6})/i', '#$2', $product['recommended_use']) !!}
                    </div>
                    @endif
                </div>
                <!--
                <div id="specifications" class="tab-pane">
                </div>
                <div id="reviews" class="tab-pane">
                </div>
                <div id="shipping" class="tab-pane">
                </div>
                -->
            </div>
        </div>

        <!-- Nutritional Value -->
        <!--
        <div class="nutrition-section">
            <h2 class="section-title">{{ __('f.nutritional_information') }}</h2>
            <div class="nutrition-disclaimer">
                <p>{{ __('f.nutrition_disclaimer') }}</p>
            </div>
            <div class="nutri-table table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('f.nutrition_name') }}</th>
                            <th>{{ __('f.per_100g') }}</th>
                            <th>{{ __('f.per_serving') }} {{ $product['serving_g'] }} g</th>
                            <th>{{ __('f.ri_percentage') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ __('f.energy') }}</td>
                            <td>{{ __('f.energy_100g') }}</td>
                            <td>{{ __('f.energy_serving') }}</td>
                            <td>{{ __('f.energy_ri') }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('f.fat') }}</td>
                            <td>{{ __('f.fat_100g') }}</td>
                            <td>{{ __('f.fat_serving') }}</td>
                            <td>{{ __('f.fat_ri') }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('f.saturates') }}</td>
                            <td>{{ __('f.saturates_100g') }}</td>
                            <td>{{ __('f.saturates_serving') }}</td>
                            <td>{{ __('f.saturates_ri') }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('f.carbohydrates') }}</td>
                            <td>{{ __('f.carbohydrates_100g') }}</td>
                            <td>{{ __('f.carbohydrates_serving') }}</td>
                            <td>{{ __('f.carbohydrates_ri') }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('f.sugars') }}</td>
                            <td>{{ __('f.sugars_100g') }}</td>
                            <td>{{ __('f.sugars_serving') }}</td>
                            <td>{{ __('f.sugars_ri') }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('f.protein') }}</td>
                            <td>{{ __('f.protein_100g') }}</td>
                            <td>{{ __('f.protein_serving') }}</td>
                            <td>{{ __('f.protein_ri') }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('f.salt') }}</td>
                            <td>{{ __('f.salt_100g') }}</td>
                            <td>{{ __('f.salt_serving') }}</td>
                            <td>{{ __('f.salt_ri') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        -->
    </div>
</div>

@include('website_commerce.home.product')
@include('website_commerce.home.best_sale')

@include('website_commerce.general_component.brand')

<style>
    :root {
        --primary-color: #2c3e50;
        --secondary-color: #e74c3c;
        --accent-color: #3498db;
        --light-gray: #f8f9fa;
        --medium-gray: #e0e0e0;
        --dark-gray: #95a5a6;
        --text-color: #333;
        --text-light: #7f8c8d;
        --border-radius: 8px;
        --box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    /* Base Styles */
    .py-5 {
        padding-top: 3rem;
        padding-bottom: 3rem;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    /* Product Container */
    .product-container {
        background: #fff;
        border-radius: var(--border-radius);
        padding: 30px;
        box-shadow: var(--box-shadow);
        margin-top: 20px;
        position: relative;
    }

    /* Heart Icon */
    .heart-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 24px;
        color: var(--dark-gray);
        cursor: pointer;
        transition: var(--transition);
        z-index: 10;
        background: white;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .heart-icon:hover {
        color: var(--secondary-color);
        transform: scale(1.1);
    }

    .heart-icon.active {
        color: var(--secondary-color);
    }

    /* Product Header */
    .product-header {
        display: flex;
        gap: 40px;
        margin-bottom: 40px;
    }

    /* Product Gallery */
    .product-gallery {
        flex: 0 0 45%;
        position: relative;
    }

    .main-image-container {
        background: var(--light-gray);
        border-radius: var(--border-radius);
        padding: 30px;
        text-align: center;
        margin-bottom: 15px;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .main-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        mix-blend-mode: multiply;
    }

    .thumbnail-container {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 10px;
    }

    .thumbnail-item {
        flex: 0 0 80px;
        height: 80px;
        border: 2px solid var(--medium-gray);
        border-radius: var(--border-radius);
        overflow: hidden;
        cursor: pointer;
        transition: var(--transition);
    }

    .thumbnail-item:hover {
        border-color: var(--secondary-color);
    }

    .thumbnail {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-details {
        flex: 1;
    }

    .product-meta {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        color: var(--text-light);
        font-size: 0.9rem;
    }

    .product-brand {
        font-weight: 600;
        color: var(--primary-color);
    }

    .product-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 15px 0;
        color: var(--primary-color);
        line-height: 1.2;
    }

    .product-description {
        margin: 20px 0;
        color: var(--text-color);
        line-height: 1.6;
    }

    /* Rating */
    .rating-container {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .stars {
        color: #f1c40f;
        margin-right: 10px;
    }

    .rating-links {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.9rem;
    }

    .rating-links a {
        color: var(--accent-color);
        text-decoration: none;
    }

    .divider {
        color: var(--medium-gray);
    }

    /* Availability */
    .availability {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #27ae60;
        font-weight: 500;
        margin-bottom: 20px;
    }

    /* Price Container */
    .price-container {
        background: var(--light-gray);
        padding: 15px;
        border-radius: var(--border-radius);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 20px 0;
    }

    .price-info {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .price-new {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--secondary-color);
        margin: 0;
    }

    .price-old {
        text-decoration: line-through;
        color: var(--dark-gray);
        font-size: 1.2rem;
        margin: 0;
    }

    .discount-badge {
        background: var(--secondary-color);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    /* Tags Section */
    .tags-section {
        margin: 20px 0;
    }

    .tags-section h4 {
        font-size: 1.1rem;
        margin-bottom: 10px;
        color: var(--primary-color);
    }

    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .product-tag {
        background: var(--light-gray);
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        color: var(--text-color);
        border: 1px solid var(--medium-gray);
    }

    /* Product Highlights */
    .product-highlights {
        margin: 20px 0;
        padding: 15px;
        background: #f9f9f9;
        border-radius: var(--border-radius);
    }

    .highlight-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 8px 0;
        color: var(--text-color);
    }

    .highlight-item i {
        color: #27ae60;
    }

    /* Specs Sections */
    .specs-section {
        margin: 25px 0;
    }

    .specs-section h4 {
        font-size: 1.2rem;
        margin-bottom: 10px;
        color: var(--primary-color);
        position: relative;
        padding-left: 15px;
    }

    .specs-section h4:before {
        content: '';
        position: absolute;
        left: 0;
        top: 5px;
        height: 60%;
        width: 4px;
        background: var(--secondary-color);
    }

    .specs-list {
        list-style-type: none;
        padding-left: 20px;
    }

    .specs-list li {
        position: relative;
        padding-left: 20px;
        margin-bottom: 8px;
        line-height: 1.5;
    }

    .specs-list li:before {
        content: '•';
        position: absolute;
        left: 0;
        color: var(--secondary-color);
        font-size: 1.2rem;
    }

    /* Quantity Selector */
    .quantity-selector {
        margin: 25px 0;
    }

    .quantity-selector label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .quantity-btn {
        width: 35px;
        height: 35px;
        border: 1px solid var(--medium-gray);
        background: white;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
    }

    .quantity-btn:hover {
        background: var(--light-gray);
    }

    .quantity-selector input {
        width: 60px;
        height: 35px;
        text-align: center;
        border: 1px solid var(--medium-gray);
        border-radius: 4px;
        font-size: 1rem;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 15px;
        margin: 30px 0;
    }

    .btn-primary,
    .btn-secondary {
        flex: 1;
        padding: 12px;
        border-radius: var(--border-radius);
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-primary {
        background: var(--secondary-color);
        color: white;
        border: none;
    }

    .btn-primary:hover {
        background: #c0392b;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: white;
        color: var(--primary-color);
        border: 1px solid var(--medium-gray);
    }

    .btn-secondary:hover {
        background: var(--light-gray);
        transform: translateY(-2px);
    }

    /* Social Sharing */
    .social-sharing {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid var(--medium-gray);
    }

    .social-sharing a {
        color: var(--text-light);
        font-size: 1.2rem;
        transition: var(--transition);
    }

    .social-sharing a:hover {
        color: var(--accent-color);
    }

    /* Product Tabs */
    .product-tabs {
        margin: 40px 0;
    }

    .tabs-nav {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0 0 20px 0;
        border-bottom: 1px solid var(--medium-gray);
    }

    .tabs-nav li {
        margin-right: 20px;
    }

    .tabs-nav li a {
        display: block;
        padding: 10px 0;
        color: var(--text-light);
        text-decoration: none;
        font-weight: 500;
        position: relative;
    }

    .tabs-nav li.active a {
        color: var(--primary-color);
    }

    .tabs-nav li.active a:after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        height: 2px;
        background: var(--secondary-color);
    }

    .tab-pane {
        display: none;
        padding: 20px 0;
    }

    .tab-pane.active {
        display: block;
    }

    /* Nutrition Section */
    .nutrition-section {
        margin: 40px 0;
    }

    .nutrition-disclaimer {
        font-size: 0.9rem;
        color: var(--text-light);
        margin-bottom: 20px;
        font-style: italic;
    }

    .nutri-table {
        margin: 20px 0;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .nutri-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .nutri-table th {
        background: var(--primary-color);
        color: white;
        padding: 12px;
        text-align: left;
    }

    .nutri-table td {
        padding: 12px;
        border-bottom: 1px solid var(--medium-gray);
    }

    .nutri-table tr:nth-child(even) {
        background: var(--light-gray);
    }

    .nutrition-footnote {
        font-size: 0.8rem;
        color: var(--text-light);
        margin-top: 10px;
    }

    /* Section Titles */
    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 30px 0 20px 0;
        color: var(--primary-color);
        position: relative;
        padding-bottom: 10px;
    }

    .section-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background: var(--secondary-color);
    }

    /* Responsive Styles */
    @media (max-width: 992px) {
        .product-header {
            flex-direction: column;
            gap: 30px;
        }

        .product-gallery {
            flex: 0 0 auto;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .product-container {
            padding: 20px;
        }

        .product-title {
            font-size: 1.6rem;
        }

        .price-new {
            font-size: 1.5rem;
        }

        .tabs-nav {
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 5px;
        }

        .main-image-container {
            height: 300px;
            padding: 20px;
        }
    }

    @media (max-width: 576px) {
        .product-header {
            gap: 20px;
        }

        .price-container {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .social-sharing {
            flex-wrap: wrap;
        }

        .thumbnail-item {
            flex: 0 0 60px;
            height: 60px;
        }
    }

    .social-sharing span {
        font-weight: 500;
        color: var(--text-color);
    }

    .social-sharing a.share-btn {
        color: var(--text-light);
        font-size: 1.2rem;
        transition: var(--transition);
        text-decoration: none;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--light-gray);
    }

    .social-sharing a.share-btn:hover {
        transform: scale(1.1);
    }

    .social-sharing a.facebook {
        background: #3b5998;
        color: white;
    }

    .social-sharing a.instagram {
        background: #e4405f;
        color: white;
    }

    .social-sharing a.whatsapp {
        background: #25d366;
        color: white;
    }

</style>

<script>
    function changeMainImage(thumbnail) {
        const mainImage = document.getElementById('mainImage');
        mainImage.src = thumbnail.src;
        mainImage.alt = thumbnail.alt;

        // Update active thumbnail
        document.querySelectorAll('.thumbnail-item').forEach(item => {
            item.classList.remove('active-thumbnail');
        });
        thumbnail.parentElement.classList.add('active-thumbnail');
    }

    // Initialize first thumbnail as active
    document.addEventListener('DOMContentLoaded', function () {
        const firstThumbnail = document.querySelector('.thumbnail-item');
        if (firstThumbnail) {
            firstThumbnail.classList.add('active-thumbnail');
            firstThumbnail.style.borderColor = 'var(--secondary-color)';
        }
    });


    function getProductDetails() {
        const productName = document.querySelector('.product-title').textContent;
        const productUrl = window.location.href;
        return {
            name: productName,
            url: productUrl
        };
    }

    function shareOnFacebook(event) {
        event.preventDefault();
        const {
            url
        } = getProductDetails();
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, '_blank',
            'width=600,height=400');
    }

    function shareOnWhatsApp(event) {
        event.preventDefault();
        const {
            name,
            url
        } = getProductDetails();
        const message = `Check out this product: ${name} - ${url}`;
        window.open(`https://api.whatsapp.com/send?text=${encodeURIComponent(message)}`, '_blank');
    }

    function shareOnInstagram(event) {
        event.preventDefault();
        alert('Instagram sharing is not directly supported via web. Please share manually.');
    }

</script>

@include('website_commerce.footer')
