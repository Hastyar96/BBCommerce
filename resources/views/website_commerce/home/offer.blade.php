
    <!-- Featured Products (3 images side by side) -->
    <section class="featured-products container mt-4">
        <div class="products-grid">
            <div class="product-item">
                <img src="https://britishbody.uk/upload/gallery/1694878824.jpg" alt="Protein Supplements"
                    class="product-image">
                <button class="product-btn">{{ __('f.more') }}</button>
            </div>
            <div class="product-item">
                <img src="https://britishbody.uk/upload/gallery/1694878824.jpg" alt="Workout Supplements"
                    class="product-image">
                <button class="product-btn">{{ __('f.more') }}</button>
            </div>
            <div class="product-item hide-on-mobile">
                <img src="https://britishbody.uk/upload/gallery/1694878824.jpg" alt="Vitamins" class="product-image">
                <button class="product-btn">{{ __('f.more') }}</button>
            </div>
        </div>
    </section>


    <!-- Featured Products style-->
    <style>
        /* Featured Products */
        .featured-products {
            margin-top: 10px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .product-item {
            background-color: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            display: flex;
            flex-direction: column;
        }

        .product-item:hover {
            transform: translateY(-5px);
        }

        .product-image {
            width: 80%;
            height: auto;
            aspect-ratio: 5 / 5;
            /* maintains consistent image ratio */
            object-fit: cover;
            margin-left: 25px;
        }

        /* Mobile-only layout: 2 items per row with spacing */
        @media (max-width: 768px) {
            .products-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .product-image {
                aspect-ratio: 4 / 4;
                /* a bit more compact image size */
            }

            .product-btn {
                font-size: 10px;
                padding: 10px 0;
            }
        }

        @media (max-width: 768px) {
            .hide-on-mobile {
                display: none !important;
            }
        }


        .product-btn {
            display: block;
            width: 100%;
            background-color: #e74c3c;
            color: #fff;
            border: none;
            padding: 12px 0;
            font-weight: 600;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .product-btn:hover {
            background-color: #c0392b;
        }
    </style>
