@include('website_commerce.header')

<div class="container mt-3 mb-5">

    <!-- Social Media Section -->
    <div class="card w-100 shadow mb-3 social-media-card">
        <div class="social-media-bg" style="background-image: url('{{ asset('image_website/image/social.jpg') }}');"></div>
        <div class="image-overlay"></div>
        <div class="card-body text-center py-4 social-media-content">
            <h3 class="mb-4">{{ __('f.connect_with_us') }}</h3>
            <div class="d-flex justify-content-center gap-3">
                <a href="https://www.facebook.com/BritishBody" target="_blank" class="btn btn-primary btn-social" aria-label="Visit us on Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://www.instagram.com/british.body/" target="_blank" class="btn btn-danger btn-social" aria-label="Visit us on Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://www.tiktok.com/@britishbodybeast" target="_blank" class="btn btn-success btn-social" aria-label="Follow us on TikTok">
                    <i class="fab fa-tiktok"></i>
                </a>
                <a href="https://wa.me/07740872106" target="_blank" class="btn btn-success btn-social" aria-label="Contact us on WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Interactive Leaflet Map -->
    <div class="map-container mb-5">
        <div id="map"></div>
    </div>

    <!-- Branch Cards -->
    @php
    $branches = [
        [
            'id' => 'uk',
            'title' => __('f.uk'),
            'image' => 'uk.jpeg',
            'address' => __('f.address_uk'),
            'phone' => '00447300554757',
            'hours' => __('f.opening_hours_uk'),
            'map' => [
                'marker' => '54.568739,-1.247176'
            ]
        ],
        [
            'id' => 'erbil',
            'title' => __('f.erbil'),
            'image' => 'hawler.jpg',
            'address' => __('f.address_erbil'),
            'phone' => '07501575148',
            'hours' => __('f.opening_hours_erbil'),
            'map' => [
                'marker' => '36.181568495710216,44.01214645116063'
            ]
        ],
        [
            'id' => 'slemani_mawlawe',
            'title' => __('f.slemani_mawlawe'),
            'image' => 'slemani.jpeg',
            'address' =>  __('f.address_slemani_mawlawe'),
            'phone' => '07701575148',
            'hours' => __('f.opening_hours_mawlawi'),
            'map' => [
                'marker' => '35.556688,45.441961'
            ]
        ],
        [
            'id' => 'slemani_kareza',
            'title' => __('f.slemani_kareza'),
            'image' => 'slemani.jpeg',
            'address' =>  __('f.address_slemani_kareza'),
            'phone' => '07740872106',
            'hours' => __('f.opening_hours_kareza'),
            'map' => [
                'marker' => '35.583148,45.426001'
            ]
        ],
        [
            'id' => 'kerkuk',
            'title' => __('f.kerkuk'),
            'image' => 'kerkuk.jpg',
            'address' =>__('f.address_kerkuk'),
            'phone' => '07700696810',
            'hours' => __('f.opening_hours_karkuk'),
            'map' => [
                'marker' => '35.458499, 44.410361'
            ]
        ],
        [
            'id' => 'ranya',
            'title' => __('f.ranya'),
            'image' => 'ranya.jpg',
            'address' => __('f.address_ranya'),
            'phone' => '07701401793',
            'hours' => __('f.opening_hours_ranya'),
            'map' => [
                'marker' => '36.254529253595805,44.88237435534795'
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
                                    onclick="window.open('https://www.google.com/maps/search/?api=1&query={{ $branch['map']['marker'] }}', '_blank')"
                                    aria-label="Open {{ $branch['title'] }} in Google Maps">
                                {{ __('f.direct') }}
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4 text-center mb-3 mb-md-0 pe-md-2 border-md-start border-dark info-column">
                        <p class="mb-0"><strong><i class="fas fa-phone-alt"></i> {{ __('f.phone_number') }}</strong></p>
                        <p class="mt-0 mb-2"><small><i>{{ $branch['phone'] }}</i></small></p>
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-outline-dark flex-grow-1 py-2 btn-mobile"
                                    onclick="window.open('https://wa.me/{{ preg_replace('/[^0-9]/', '', $branch['phone']) }}', '_blank')"
                                    aria-label="Send WhatsApp message to {{ $branch['title'] }}">
                                <i class="fab fa-whatsapp"></i> {{ __('f.whatsapp') }}
                            </button>
                            <button class="btn btn-outline-dark flex-grow-1 py-2 btn-mobile"
                                    onclick="window.location.href='tel:{{ $branch['phone'] }}'"
                                    aria-label="Call {{ $branch['title'] }}">
                                <i class="fa fa-phone"></i> {{ __('f.call') }}
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4 text-center border-md-start border-dark info-column">
                        <p class="mb-0"><strong><i class="far fa-clock"></i> {{ __('f.time') }}</strong></p>
                        <p class="mt-0 mb-0"><small><i>{{ $branch['hours'] }}</i></small></p>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center m-0 p-0 py-2">
                <button class="border-0 bg-transparent d-inline-flex align-items-center gap-1 view-more-btn"
                        type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse-{{ $branch['id'] }}" aria-expanded="false"
                        aria-controls="collapse-{{ $branch['id'] }}"
                        aria-label="Toggle more information for {{ $branch['title'] }}">
                    {{ __('f.more') }}
                    <i class="fa fa-angle-down toggle-icon" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
    /* Where to Buy Title Styling */
    .shahada-title {
        font-size: 36px;
        font-weight: 700;
        color: #333;
        text-transform: uppercase;
        margin-bottom: 20px;
        letter-spacing: 1.5px;
        position: relative;
    }

    .shahada-title::after {
        content: "";
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 2px;
        background-color: #121B3F;
    }

    /* Map Styling */
    .map-container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    #map {
        height: 500px;
        width: 100%;
        border-radius: 10px;
    }

    /* Social Media Section */
    .social-media-card {
        border-radius: 15px;
        overflow: hidden;
        position: relative;
        height: 180px;
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
        filter: brightness(0.8);
        z-index: 0;
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(18, 27, 63, 0.6);
        z-index: 1;
    }

    .social-media-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
    }

    .social-media-content h3 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
        letter-spacing: 1px;
    }

    .btn-social {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        border: 2px solid white;
        color: white;
        font-size: 1.4rem;
        transition: all 0.3s ease-in-out;
        background-color: rgba(255, 255, 255, 0.1);
    }

    .btn-social:hover {
        transform: scale(1.1) translateY(-3px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.3);
        background-color: white;
        color: #121B3F;
    }

    /* Branch Card Styles */
    .branch-card {
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .branch-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .hero-image-container {
        position: relative;
        height: 180px;
        width: 100%;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        overflow: hidden;
    }

    .hero-image {
        height: 100%;
        object-fit: cover;
        width: 100%;
        filter: brightness(0.85);
    }

    .hero-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-family: 'Bebas Neue', sans-serif;
        font-size: 3rem;
        font-weight: bold;
        color: white;
        text-shadow: 0 0 10px rgba(0,0,0,0.7);
        z-index: 2;
        white-space: nowrap;
    }

    .card-body-content {
        padding: 1rem 1.5rem;
    }

    .info-column {
        padding: 1rem 0.5rem;
    }

    .info-column p {
        margin-bottom: 0.25rem;
    }

    .info-column strong {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #121B3F;
        font-size: 1.1rem;
    }

    .info-column small i {
        font-style: normal;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .btn-outline-dark {
        border-color: #121B3F;
        color: #121B3F;
        transition: all 0.3s ease;
        border-width: 2px;
        font-weight: 600;
    }

    .btn-outline-dark:hover {
        background-color: #121B3F;
        color: white;
        border-color: #121B3F;
    }

    .btn-mobile i {
        margin-right: 5px;
    }

    .view-more-btn {
        font-size: 1.05rem;
        color: #121B3F;
        font-weight: bold;
        padding: 0.75rem 0;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: color 0.2s ease;
    }

    .view-more-btn:hover {
        color: #0d132a;
    }

    .toggle-icon {
        transition: transform 0.3s ease;
        display: inline-block;
        font-size: 0.9rem;
    }

    [aria-expanded="true"] .toggle-icon {
        transform: rotate(180deg);
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
            border-left: none !important;
            border-top: 1px solid #eee;
            padding-top: 1.5rem;
            margin-top: 1.5rem;
        }
        .info-column:first-child {
            border-top: none;
            padding-top: 0;
            margin-top: 0;
        }
        .shahada-title {
            font-size: 28px;
        }
        .map-container {
            padding: 15px;
        }
    }

    @media (min-width: 768px) {
        .border-md-start {
            border-left: 1px solid #dee2e6 !important;
        }
    }
</style>

<!-- Leaflet JS and Map Script -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let mapInstance; // Store map instance globally

    document.addEventListener('DOMContentLoaded', function () {
        // Initialize the map
        mapInstance = L.map('map', {
            attributionControl: false
        });

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '<span>British Body | </span>© OpenStreetMap contributors'
        }).addTo(mapInstance);

        // Enable custom attribution
        L.control.attribution({ position: 'bottomright' })
            .addAttribution('<span style="font-weight: bold;">British Body</span>')
            .addTo(mapInstance);

        // Array to store coordinates for polylines and bounds
        let branchCoords = [];

        // Add markers for each branch
        @foreach($branches as $branch)
            var coords_{{ $branch['id'] }} = [{{ $branch['map']['marker'] }}];
            var marker_{{ $branch['id'] }} = L.marker(coords_{{ $branch['id'] }})
                .addTo(mapInstance)
                .bindPopup('<b>{{ $branch['title'] }}</b>')
                .on('click', function() {
                    mapInstance.setView(coords_{{ $branch['id'] }}, 15);
                });
            branchCoords.push(coords_{{ $branch['id'] }});
        @endforeach

        // Fit map to bounds of all branches
        if (branchCoords.length > 0) {
            mapInstance.fitBounds(branchCoords, { padding: [50, 50] });
        }

        // Add polyline connecting all branches
        if (branchCoords.length > 1) {
            L.polyline(branchCoords, {
                color: '#121B3F', // Match theme color
                weight: 3,
                opacity: 0.7
            }).addTo(mapInstance);
        }
    });

    // Handle collapse toggles and URL hash scrolling
    $(document).ready(function() {
        $('[data-bs-toggle="collapse"]').each(function() {
            var target = $(this).data('bs-target');
            $(target).on('show.bs.collapse', function() {
                $('[data-bs-target="' + target + '"] .toggle-icon').css('transform', 'rotate(180deg)');
            }).on('hide.bs.collapse', function() {
                $('[data-bs-target="' + target + '"] .toggle-icon').css('transform', 'rotate(0deg)');
            });
        });

        if(window.location.hash) {
            var branchId = window.location.hash.substring(1);
            var $branch = $('#' + branchId);
            if($branch.length) {
                $('html, body').animate({
                    scrollTop: $branch.offset().top - 80
                }, 500);
                var $collapse = $branch.find('.collapse');
                if($collapse.length && !$collapse.hasClass('show')) {
                    $collapse.collapse('show');
                }
            }
        }
    });
</script>

@include('website_commerce.footer')
