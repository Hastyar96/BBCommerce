@php
 $brands = App\Models\Brand::all();
@endphp
<!-- Brands Section -->
<div class="container">
    <section class="brands-section">
        <h2 class="section-title">{{ __('f.our_brand') }}</h2>
        <div class="brands-container">
            @foreach($brands as $brand)
            <a href="{{ url('products?brand_id=/'.$brand->id) }}">
                <div class="brand-card">
                    <div class="logo-container">
                        <img src="{{ asset($brand->logo) }}" alt="{{ $brand->name }}">
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </section>
</div>

<style>
    /* Brands Section */
    .brands-section {
        max-width: 1200px;
        margin: 60px auto;
        padding: 0 15px;
    }

    .section-title {
        text-align: center;
        margin-bottom: 30px;
        font-size: 28px;
        color: #333;
    }

    .brands-container {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 20px;
    }

    .brand-card {
        background-color: #fff;
        border-radius: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s, box-shadow 0.3s;
        aspect-ratio: 1/1;
        padding: 15px;
    }

    .brand-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .logo-container {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px;
    }

    .brand-card img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        filter: grayscale(100%);
        opacity: 0.7;
        transition: all 0.3s;
    }

    .brand-card:hover img {
        filter: grayscale(0%);
        opacity: 1;
    }

    /* Responsive Styles for Brands Section */
    @media (max-width: 1200px) {
        .brands-container {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (max-width: 768px) {
        .brands-container {
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .brands-section {
            margin: 40px auto;
        }

        .section-title {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .brand-card {
            padding: 10px;
        }
    }

    @media (max-width: 480px) {
        .brands-container {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .brands-section {
            margin: 30px auto;
        }

        .section-title {
            font-size: 20px;
        }
    }
</style>
