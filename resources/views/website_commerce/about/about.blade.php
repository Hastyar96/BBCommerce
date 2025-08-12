@include('website_commerce.header')

<div class="container my-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h2 class="display-5 font-weight-bold mb-4" style="color: #121B3F; font-family: 'Bebas Neue', sans-serif;">{{__('f.welcome_title')}}</h2>
            <p class="lead text-muted mx-auto" style="max-width: 800px;">
                {{__('f.welcome_description_1')}}
            </p>
            <p class="text-muted mx-auto" style="max-width: 800px;">
                {{__('f.welcome_description_2')}}
            </p>
        </div>
    </div>

    <hr class="my-5 border-purple">

    <div class="row">
        <div class="col-12 text-center my-3">
            <h4 class="display-6 font-weight-bold" style="color: #322661;">{{__('f.discover_brands')}}</h4>
        </div>

        {{-- BRAND 1 SECTION: SynTech Nutrition --}}
        <div class="col-12 my-4 brand-section" id="brand-a">
            <div class="row align-items-stretch">
                <div class="col-md-6 d-flex">
                    <div class="brand-image-wrapper flex-grow-1">
                        <img src="https://syntech-nutrition.com/pub/media/wysiwyg/SynPro_Whey_labelling__2.jpg" alt="{{__('f.syntech_alt')}}" class="brand-side-image">
                        <div class="image-overlay"></div>
                        <div class="brand-name-overlay">{{__('f.syntech_name')}}</div>
                    </div>
                </div>
                <div class="col-md-6 mt-3 mt-md-0 d-flex flex-column justify-content-center">
                    <h4 class="font-weight-bold custom-title-color text-center">{{__('f.syntech_title')}}</h4>
                    <p class="text-center brand-description-text">{{__('f.syntech_description_1')}}</p>
                    <p class="text-center brand-description-text">{{__('f.syntech_description_2')}}</p>
                    <p class="text-center brand-description-text">{{__('f.syntech_description_3')}}</p>
                    <a href="https://syntech-nutrition.com/en/about" target="_blank" class="btn btn-outline-dark btn-sm">
                        <i class="fas fa-info-circle"></i> {{__('f.learn_more')}}
                    </a>
                </div>
            </div>
        </div>

        <hr class="my-5 border-purple">

        {{-- BRAND 2 SECTION: British Body Beast --}}
        <div class="col-12 my-4 brand-section" id="brand-b">
            <div class="row align-items-stretch">
                <div class="col-md-6 order-md-2 d-flex">
                    <div class="brand-image-wrapper flex-grow-1">
                        <img src="https://britishbodybeast.com/img/part1.png" alt="{{__('f.bodybeast_alt')}}" class="brand-side-image">
                        <div class="image-overlay"></div>
                        <div class="brand-name-overlay">{{__('f.bodybeast_name')}}</div>
                    </div>
                </div>
                <div class="col-md-6 mt-3 mt-md-0 d-flex flex-column justify-content-center">
                    <h4 class="font-weight-bold custom-title-color text-center">{{__('f.bodybeast_title')}}</h4>
                    <p class="text-center brand-description-text">{{__('f.bodybeast_description_1')}}</p>
                    <p class="text-center brand-description-text">{{__('f.bodybeast_description_2')}}</p>
                    <p class="text-center brand-description-text">{{__('f.bodybeast_description_3')}}</p>
                    <a href="https://britishbodybeast.com/" target="_blank" class="btn btn-outline-dark btn-sm">
                        <i class="fas fa-info-circle"></i> {{__('f.learn_more')}}
                    </a>
                </div>
            </div>
        </div>

        <hr class="my-5 border-purple">

        {{-- BRAND 3 SECTION: Fit & Shape --}}
        <div class="col-12 my-4 brand-section" id="brand-c">
            <div class="row align-items-stretch">
                <div class="col-md-6 d-flex">
                    <div class="brand-image-wrapper flex-grow-1">
                        <img src="https://fitandshape.eu/media/wysiwyg/FactoryPhotos/Storage_1-1.jpg" alt="{{__('f.fitshape_alt')}}" class="brand-side-image">
                        <div class="image-overlay"></div>
                        <div class="brand-name-overlay">{{__('f.fitshape_name')}}</div>
                    </div>
                </div>
                <div class="col-md-6 mt-3 mt-md-0 d-flex flex-column justify-content-center">
                    <h4 class="font-weight-bold custom-title-color text-center">{{__('f.fitshape_title')}}</h4>
                    <p class="text-center brand-description-text">{{__('f.fitshape_description_1')}}</p>
                    <p class="text-center brand-description-text">{{__('f.fitshape_description_2')}}</p>
                    <p class="text-center brand-description-text">{{__('f.fitshape_description_3')}}</p>
                    <a href="https://fitandshape.eu/about-fitandshape" target="_blank" class="btn btn-outline-dark btn-sm">
                        <i class="fas fa-info-circle"></i> {{__('f.learn_more')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* --- General Page Styles --- */
    .custom-title-color {
        color: #322661; /* Dark purple */
        margin-bottom: 1rem;
    }
    .border-purple {
        border-top: 2px solid #322661;
        opacity: 0.2;
    }

    /* --- Brand Section Wrapper (Card-like) --- */
    .brand-section {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        overflow: hidden;
        padding: 2rem;
    }

    /* --- Image and Overlay for Side-by-Side Layout --- */
    .brand-image-wrapper {
        position: relative;
        height: 100%; /* Make wrapper fill its d-flex parent */
        width: 100%;
        overflow: hidden;
        border-radius: 10px;
    }

    .brand-side-image {
        height: 100%; /* Make image fill its parent wrapper */
        width: 100%;
        object-fit: cover;
        filter: brightness(0.7);
        transition: filter 0.3s ease;
    }

    .brand-image-wrapper:hover .brand-side-image {
        filter: brightness(0.9);
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
        z-index: 1;
        border-radius: 10px;
    }

    .brand-name-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2.5rem;
        font-weight: bold;
        color: white;
        text-shadow: 0 0 10px rgba(0,0,0,0.8);
        z-index: 2;
        text-align: center;
        width: 90%;
        line-height: 1.1;
    }

    /* --- Text Alignment & Equal Height Flexbox --- */
    .row.align-items-stretch {
        display: flex;
        flex-wrap: wrap;
    }

    .col-md-6.d-flex {
        display: flex;
        flex-direction: column;
    }

    .col-md-6.d-flex.flex-column.justify-content-center {
        justify-content: center;
        text-align: center;
    }

    .custom-title-color,
    .brand-description-text {
        text-align: center !important;
    }

    @media (max-width: 767.98px) {
        .row.align-items-stretch {
            align-items: flex-start !important;
        }
        .col-md-6.d-flex {
            margin-bottom: 1.5rem;
        }
        .col-md-6.d-flex:last-child {
            margin-bottom: 0;
        }
    }
</style>

@include('website_commerce.footer')
