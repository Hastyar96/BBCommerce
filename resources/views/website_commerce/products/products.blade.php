@include('website_commerce.header')
<div class="container">
    <!-- Search & Filter Section -->
    <form method="GET">
        <div class="search-filter-section">
            <!-- Search Bar -->
            <div class="search-bar">
                <input type="text" name="search" placeholder="{{ __('f.search_placeholder') }}" value="{{ request('search') }}">
                <button type="submit" style="background-color: #e74c3c;">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <!-- Filters -->
            <div class="filters">
                <!-- Category Filter -->
                <div class="filter-group">
                    <label for="category">{{ __('f.category') }}</label>
                    <select name="category_id" id="category">
                        <option value="">{{ __('f.all_categories') }}</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->langs->first()?->name ?? '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Goal Filter -->
                <div class="filter-group">
                    <label for="goal">{{ __('f.goal') }}</label>
                    <select name="goal_id" id="goal">
                        <option value="">{{ __('f.all_goals') }}</option>
                        @foreach ($goals as $goal)
                            <option value="{{ $goal->id }}" {{ request('goal_id') == $goal->id ? 'selected' : '' }}>
                                {{ $goal->langs->first()?->name ?? '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Brand Filter -->
                <div class="filter-group">
                    <label for="brand">{{ __('f.brand') }}</label>
                    <select name="brand_id" id="brand">
                        <option value="">{{ __('f.all_brands') }}</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tag Filter -->
                <div class="filter-group">
                    <label for="tag">{{ __('f.tag') }}</label>
                    <select name="tag_id" id="tag">
                        <option value="">{{ __('f.all_tags') }}</option>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}" {{ request('tag_id') == $tag->id ? 'selected' : '' }}>
                                {{ $tag->langs->first()?->name ?? '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </form>

    <!-- Product Grid -->
    <div class="products-grid">
        @forelse ($products as $product)
            <div class="product-card">
                <div class="product-image justify-content-center align-items-center d-flex">
                    <a href="{{ url('/product/' . $product['id']) }}" style="text-decoration: none" class="product-card-link">
                        <img src="{{ asset($product['image'][0] ?? 'img/no-image.png') }}" alt="{{ $product['name'] }}">
                    </a>
                    @if($product['best_sale'] == 1)
                        <div class="product-badge">{{ __('f.bestsellers') }}</div>
                    @endif
                </div>
                <div class="product-info">
                    <div class="product-category">{{ $product['category'] }}</div>
                    <?php
                        $productName = $product['name'];
                        $maxLength = 14;

                        if (mb_strlen($productName, 'UTF-8') > $maxLength) {
                            $displayProductName = mb_substr($productName, 0, $maxLength, 'UTF-8') . '...';
                        } else {
                            $displayProductName = $productName;
                        }
                    ?>
                    <h3 class="product-title">{{ $displayProductName }}</h3>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span class="reviews">(128)</span>
                    </div>
                    <div class="product-price">
                        <div>
                            <span class="price">{{ number_format($product['price']) }} {{ $product['currency_symbol'] }}</span>
                        </div>
                        <button class="add-to-cart" data-bs-toggle="modal" data-bs-target="#downloadAppModal">
                            <i class="fas fa-shopping-cart"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="no-products">
                <p>{{ __('f.no_products_found') }}</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($products->hasPages())
        <div class="pagination-container">
            <div class="pagination-info">
                Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
            </div>

            <nav aria-label="Page navigation">
                <ul class="pagination">
                    {{-- First Page Link --}}
                    @if ($products->currentPage() > 2)
                        <li class="page-item">
                            <a class="page-link" href="{{ $products->url(1) }}" aria-label="First">
                                <span aria-hidden="true">&laquo;&laquo;</span>
                            </a>
                        </li>
                    @endif

                    {{-- Previous Page Link --}}
                    @if ($products->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @php
                        $current = $products->currentPage();
                        $last = $products->lastPage();
                        $start = max($current - 2, 1);
                        $end = min($current + 2, $last);

                        if ($current <= 3) {
                            $end = min(5, $last);
                        }

                        if ($current >= $last - 2) {
                            $start = max($last - 4, 1);
                        }
                    @endphp

                    @if($start > 1)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        @if ($i == $products->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $i }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor

                    @if($end < $last)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($products->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </span>
                        </li>
                    @endif

                    {{-- Last Page Link --}}
                    @if ($products->currentPage() < $products->lastPage() - 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $products->url($products->lastPage()) }}" aria-label="Last">
                                <span aria-hidden="true">&raquo;&raquo;</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    @endif
</div>
@include('website_commerce.home.best_sale')
@include('website_commerce.general_component.brand')

<style>
/* Search & Filter Styles */
.search-filter-section {
    background: white;
    border-radius: 15px;
    padding: 20px;
    margin: 30px 0;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
}

.search-bar {
    display: flex;
    margin-bottom: 20px;
}

.search-bar input {
    flex: 1;
    padding: 14px 20px;
    border: none;
    background: #f8f9fa;
    border-radius: 12px 0 0 12px;
    font-size: 1rem;
    box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.search-bar input:focus {
    outline: none;
    background: #ffffff;
    box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.1), 0 0 0 3px rgba(66, 153, 225, 0.2);
}

.search-bar button {
    padding: 0 25px;
    background: #3498db;
    color: white;
    border: none;
    border-radius: 0 12px 12px 0;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.search-bar button:hover {
    background: #2980b9;
}

.filters {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    padding-top: 10px;
}

.filter-group {
    flex: 1;
    min-width: 180px;
}

.filter-group label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.9rem;
}

.filter-group select {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #e0e6ed;
    background: #f8f9fa;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.filter-group select:focus {
    outline: none;
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
}

/* Product Grid Styles */
.products-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 25px;
    margin-top: 20px;
}

.product-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    display: flex;
    flex-direction: column;
    height: 100%;
}

.product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.product-image {
    height: 200px;
    overflow: hidden;
    position: relative;
}

.product-image img {
    width: 50%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
    margin-left: 70px;
}

.product-card:hover .product-image img {
    transform: scale(1.05);
}

.product-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: #e74c3c;
    color: white;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.product-info {
    padding: 15px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.product-category {
    color: #3498db;
    font-weight: 600;
    font-size: 0.8rem;
    margin-bottom: 5px;
}

.product-title {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 8px;
    color: #2c3e50;
}

.product-description {
    color: #7f8c8d;
    margin-bottom: 12px;
    font-size: 0.9rem;
    flex: 1;
}

.product-price {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 12px;
}

.price {
    font-size: 1.3rem;
    font-weight: 800;
    color: #2c3e50;
}

.original-price {
    text-decoration: line-through;
    color: #95a5a6;
    font-size: 0.9rem;
    margin-left: 6px;
}

.add-to-cart {
    background: #e74c3c;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.9rem;
}

.add-to-cart:hover {
    background: #c0392b;
}

.rating {
    color: #f39c12;
    margin: 6px 0;
    font-size: 0.9rem;
}

.rating i {
    margin-right: 2px;
}

.reviews {
    color: #95a5a6;
    font-size: 0.8rem;
    margin-left: 5px;
}

/* Pagination Styles */
.pagination-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 40px 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.pagination-info {
    margin-bottom: 15px;
    color: #6c757d;
    font-size: 0.9rem;
    font-weight: 500;
}

.pagination {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.page-item {
    margin: 0;
}

.page-link {
    position: relative;
    display: block;
    padding: 0.75rem 1rem;
    margin-left: -1px;
    line-height: 1.25;
    color: #3498db;
    background-color: #fff;
    border: 1px solid #dee2e6;
    text-decoration: none;
    transition: all 0.3s ease;
    font-weight: 600;
    min-width: 45px;
    text-align: center;
}

.page-item:first-child .page-link {
    margin-left: 0;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
}

.page-item:last-child .page-link {
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
}

.page-item.active .page-link {
    z-index: 1;
    color: #fff;
    background-color: #e74c3c;
    border-color: #e74c3c;
}

.page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    background-color: #fff;
    border-color: #dee2e6;
}

.page-link:hover {
    z-index: 2;
    color: #e74c3c;
    background-color: #f8f9fa;
    border-color: #dee2e6;
}

.page-link:focus {
    z-index: 3;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(231, 76, 60, 0.25);
}

/* No Products Found */
.no-products {
    grid-column: 1 / -1;
    text-align: center;
    padding: 40px;
    color: #7f8c8d;
    font-size: 1.1rem;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .products-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 900px) {
    .products-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .filters {
        gap: 15px;
    }

    .filter-group {
        min-width: calc(50% - 8px);
    }
}

@media (max-width: 600px) {
    .products-grid {
        grid-template-columns: 1fr;
    }

    .search-bar {
        flex-direction: column;
    }

    .search-bar input {
        border-radius: 12px;
        margin-bottom: 10px;
    }

    .search-bar button {
        border-radius: 12px;
        padding: 12px;
    }

    .filters {
        flex-direction: column;
        gap: 15px;
    }

    .filter-group {
        min-width: 100%;
    }

    /* Responsive Pagination */
    .pagination {
        flex-wrap: wrap;
        justify-content: center;
        border-radius: 0;
        box-shadow: none;
    }

    .page-item {
        margin: 2px;
    }

    .page-item:first-child .page-link,
    .page-item:last-child .page-link {
        border-radius: 5px;
    }

    .page-link {
        padding: 0.5rem 0.75rem;
        min-width: 40px;
        border-radius: 5px !important;
    }
}
</style>
@include('website_commerce.footer')
