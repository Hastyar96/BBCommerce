@include('website_commerce.header')
<div class="container">
    <div class="card w-100 shadow mb-5 social-media-card">
        <div class="social-media-bg" style="background-image: url('{{ asset('image_website/image/social.jpg') }}');"></div>
        <div class="image-overlay"></div>

        <div class="card-body text-center py-4 social-media-content">
            <h3 class="mb-4">{{ __('f.connect_with_us') }}</h3>
            <div class="d-flex justify-content-center gap-3">
                <a href="https://facebook.com/yourpage" target="_blank" class="btn btn-primary btn-social">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://instagram.com/yourpage" target="_blank" class="btn btn-danger btn-social">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://twitter.com/yourpage" target="_blank" class="btn btn-info btn-social">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://youtube.com/yourchannel" target="_blank" class="btn btn-danger btn-social">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="https://wa.me/yournumber" target="_blank" class="btn btn-success btn-social">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
        </div>
    </div>

    @php
        $branches = [
            [
                'id' => 'erbil',
                'title' => __('f.erbil'),
                'image' => 'hawler.jpg',
                'address' => __('f.address_erbil'),
                'phone' => '07708949000',
                'hours' => __('f.opening_hours'),
                'map' => [
                    'bbox' => '45.440,35.560,45.444,35.564',
                    'marker' => '35.5621,45.4420'
                ]
            ],
            [
                'id' => 'slemani_mawlawe',
                'title' => __('f.slemani_mawlawe'),
                'image' => 'slemani.jpeg',
                'address' => __('f.address_slemani_mawlawe'),
                'phone' => '07701234567',
                'hours' => __('f.opening_hours'),
                'map' => [
                    'bbox' => '45.430,35.550,45.434,35.554',
                    'marker' => '35.5521,45.4320'
                ]
            ],
            [
                'id' => 'slemani_kareza',
                'title' => __('f.slemani_kareza'),
                'image' => 'slemani.jpeg',
                'address' => __('f.address_slemani_kareza'),
                'phone' => '07707654321',
                'hours' => __('f.opening_hours'),
                'map' => [
                    'bbox' => '45.420,35.540,45.424,35.544',
                    'marker' => '35.5421,45.4220'
                ]
            ],
            [
                'id' => 'kerkuk',
                'title' => __('f.kerkuk'),
                'image' => 'kerkuk.jpg',
                'address' => __('f.address_kerkuk'),
                'phone' => '07709876543',
                'hours' => __('f.opening_hours'),
                'map' => [
                    'bbox' => '44.380,35.460,44.384,35.464',
                    'marker' => '35.4621,44.3820'
                ]
            ],
            [
                'id' => 'ranya',
                'title' => __('f.ranya'),
                'image' => 'ranya.jpg',
                'address' => __('f.address_ranya'),
                'phone' => '07705678901',
                'hours' => __('f.opening_hours'),
                'map' => [
                    'bbox' => '44.880,36.250,44.884,36.254',
                    'marker' => '36.2521,44.8820'
                ]
            ],
            [
                'id' => 'uk',
                'title' => __('f.uk_branch'),
                'image' => 'uk.jpeg',
                'address' => __('f.address_uk'),
                'phone' => '+441234567890',
                'hours' => __('f.opening_hours_uk'),
                'map' => [
                    'bbox' => '-0.150,51.500,-0.140,51.510',
                    'marker' => '51.505,-0.145'
                ]
            ]
        ];
    @endphp

    @foreach($branches as $branch)
    <div class="card w-100 shadow mb-5 branch-card" id="{{ $branch['id'] }}">

        <div class="hero-image-container">
            <img src="{{ asset('image_website/image/' . $branch['image']) }}"
                class="card-img-top hero-image" alt="{{ $branch['title'] }}">

            <div class="image-overlay"></div>

            <div class="hero-text">
                {{ $branch['title'] }}
            </div>
        </div>

        <div class="card-body pb-0 pt-0 card-body-content">
            <div class="collapse" id="collapse-{{ $branch['id'] }}">
                <div class="row mt-1">
                    <div class="col-md-4 text-center mb-3 mb-md-0 pe-md-2 info-column">
                        <p class="mb-0"><strong><i class="fas fa-map-marker-alt"></i> {{ __('f.location') }}</strong></p>
                        <p class="mt-0 mb-2"><small><i>{{ $branch['address'] }}</i></small></p>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-outline-dark w-100 py-2 btn-mobile"
                                onclick="window.open('https://www.google.com/maps/dir/?api=1&destination={{ $branch['map']['marker'] }}', '_blank')">
                                {{ __('f.show') }}
                            </button>
                        </div>
                    </div>

                    <div class="col-md-4 text-center mb-3 mb-md-0 pe-md-2 border-md-start border-dark info-column">
                        <p class="mb-0"><strong><i class="fas fa-phone-alt"></i> {{ __('f.phone_number') }}</strong></p>
                        <p class="mt-0 mb-2"><small><i>{{ $branch['phone'] }}</i></small></p>
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-outline-dark flex-grow-1 py-2 btn-mobile"
                                    onclick="window.open('https://wa.me/{{ preg_replace('/[^0-9]/', '', $branch['phone']) }}', '_blank')">
                                <i class="fab fa-whatsapp"></i> {{ __('f.whatsapp') }}
                            </button>
                           <button class="btn btn-outline-dark flex-grow-1 py-2 btn-mobile"
                                    onclick="window.location.href='tel:{{ $branch['phone'] }}'">
                                <i class="fa fa-phone"></i> {{ __('f.call') }}
                            </button>
                        </div>
                    </div>

                    <div class="col-md-4 text-center border-md-start border-dark info-column">
                        <p class="mb-0"><strong><i class="far fa-clock"></i> {{ __('f.time') }}</strong></p>
                        <p class="mt-0 mb-0"><small><i>{{ $branch['hours'] }}</i></small></p>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="map-container">
                            <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0"
                                marginwidth="0"
                                src="https://www.openstreetmap.org/export/embed.html?bbox={{ $branch['map']['bbox'] }}&layer=mapnik&marker={{ $branch['map']['marker'] }}"
                                style="border-radius: 8px; border: 1px solid #ddd;"
                                aria-label="{{ __('f.map_of') }} {{ $branch['title'] }}">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center m-0 p-0 py-2">
                <button class="border-0 bg-transparent d-inline-flex align-items-center gap-1 view-more-btn"
                    type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse-{{ $branch['id'] }}" aria-expanded="false"
                    aria-controls="collapse-{{ $branch['id'] }}">
                    {{ __('f.more') }}
                    <i class="fa fa-angle-down toggle-icon" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>
<style>
    /* General Body and Container */
body {
    font-family: 'Open Sans', sans-serif; /* Example: A clean, readable sans-serif font */
    background-color: #f8f9fa; /* Light background for contrast */
}

.container {
    padding-top: 2rem;
    padding-bottom: 2rem;
}

/* --- Social Media Section --- */
.social-media-card {
    border-radius: 15px; /* Softer edges */
    overflow: hidden;
    position: relative;
    height: 180px; /* Slightly taller for more impact */
    display: flex;
    align-items: center;
    justify-content: center;
}

.social-media-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    filter: brightness(0.8); /* Slightly dim the image */
    z-index: 0;
}

.image-overlay {
    background-color: rgba(18, 27, 63, 0.6); /* Deeper, slightly more opaque overlay */
    z-index: 1;
}

.social-media-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
}

.social-media-content h3 {
    font-family: 'Bebas Neue', sans-serif; /* Consistent title font */
    font-size: 2.5rem;
    margin-bottom: 1.5rem;
    letter-spacing: 1px;
}

.btn-social {
    width: 48px; /* Slightly larger buttons */
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    border: 2px solid white;
    color: white;
    font-size: 1.4rem; /* Larger icons */
    transition: all 0.3s ease-in-out; /* Smoother transition */
    background-color: rgba(255, 255, 255, 0.1); /* Slight translucent background */
}

.btn-social:hover {
    transform: scale(1.1) translateY(-3px); /* More pronounced hover effect */
    box-shadow: 0 6px 12px rgba(0,0,0,0.3);
    background-color: white;
    color: #121B3F; /* Icon color changes on hover */
}

/* --- Branch Card Styles --- */
.branch-card {
    border-radius: 15px; /* Consistent rounded corners */
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transition for hover */
}

.branch-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1); /* Subtle lift and shadow on hover */
}

.hero-image-container {
    position: relative;
    height: 180px; /* Increased height for hero image */
    width: 100%;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
    overflow: hidden; /* Ensure rounded corners apply to image */
}

.hero-image {
    height: 100%;
    object-fit: cover;
    width: 100%;
    filter: brightness(0.85); /* Slightly dim the branch image as well */
}

.hero-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-family: 'Bebas Neue', sans-serif;
    font-size: 3rem; /* Larger font size for impact */
    font-weight: bold;
    color: white;
    text-shadow: 0 0 10px rgba(0,0,0,0.7); /* Stronger text shadow */
    z-index: 2;
    white-space: nowrap; /* Prevents title from breaking */
}

.card-body-content {
    padding: 1rem 1.5rem; /* More internal padding */
}

.info-column {
    padding: 1rem 0.5rem; /* Adjust padding for info columns */
}

.info-column p {
    margin-bottom: 0.25rem;
}

.info-column strong {
    display: flex; /* Allow icon next to text */
    align-items: center;
    justify-content: center;
    gap: 8px; /* Space between icon and text */
    color: #121B3F; /* Title color */
    font-size: 1.1rem;
}

.info-column small i {
    font-style: normal; /* Remove italics for address */
    color: #6c757d; /* Lighter color for details */
    font-size: 0.9rem;
}

.btn-outline-dark {
    border-color: #121B3F;
    color: #121B3F;
    transition: all 0.3s ease;
    border-width: 2px; /* Thicker border */
    font-weight: 600; /* Bolder text */
}

.btn-outline-dark:hover {
    background-color: #121B3F;
    color: white;
    border-color: #121B3F;
}

.btn-mobile i {
    margin-right: 5px; /* Space between icon and text */
}

.map-container {
    height: 300px; /* Taller map for better viewing */
    border-radius: 10px; /* More rounded map corners */
    overflow: hidden;
    border: 1px solid #ddd;
    box-shadow: inset 0 0 8px rgba(0,0,0,0.05); /* Inner shadow for depth */
}

.view-more-btn {
    font-size: 1.05rem;
    color: #121B3F;
    font-weight: bold;
    padding: 0.75rem 0; /* More padding for a clickable area */
    display: flex;
    align-items: center;
    gap: 5px;
    transition: color 0.2s ease;
}

.view-more-btn:hover {
    color: #0d132a; /* Slightly darker on hover */
}

.toggle-icon {
    font-size: 0.9rem; /* Smaller, more subtle icon */
}

/* Responsive Adjustments */
@media (max-width: 767.98px) {
    .social-media-content h3 {
        font-size: 2rem;
    }
    .btn-social {
        width: 42px;
        height: 42px;
        font-size: 1.2rem;
    }
    .hero-text {
        font-size: 2.2rem;
    }
    .info-column {
        border-left: none !important; /* Remove border on small screens */
        border-top: 1px solid #eee; /* Add top border for separation */
        padding-top: 1.5rem;
        margin-top: 1.5rem;
    }
    .info-column:first-child {
        border-top: none;
        padding-top: 0;
        margin-top: 0;
    }
}

@media (min-width: 768px) {
    .border-md-start {
        border-left: 1px solid #dee2e6 !important;
    }
}
</style>

<script>
$(document).ready(function() {
    // Handle all collapse toggles
    $('[data-bs-toggle="collapse"]').each(function() {
        var target = $(this).data('bs-target');
        $(target).on('show.bs.collapse', function() {
            $('[data-bs-target="' + target + '"] .toggle-icon').css('transform', 'rotate(180deg)');
        }).on('hide.bs.collapse', function() {
            $('[data-bs-target="' + target + '"] .toggle-icon').css('transform', 'rotate(0deg)');
        });
    });

    // Scroll to branch if hash exists in URL
    if(window.location.hash) {
        var branchId = window.location.hash.substring(1);
        var $branch = $('#' + branchId);
        if($branch.length) {
            $('html, body').animate({
                scrollTop: $branch.offset().top - 80 // Adjust offset for fixed header if any
            }, 500);

            // Open the collapse if it's closed
            var $collapse = $branch.find('.collapse');
            if($collapse.length && !$collapse.hasClass('show')) {
                $collapse.collapse('show');
            }
        }
    }
});
</script>

@include('website_commerce.footer')
