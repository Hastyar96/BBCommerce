@php
use App\Models\Language;

// Get language ID: from user or session fallback
$languageId = Auth::user()?->language_id ?? session('language_id', 1);

// Get language record
$code = Language::find($languageId);

// Fallback to 'en' if not found
$lang = $code->code ?? 'en';
App::setLocale($lang);

@endphp

<!doctype html>
<html lang="{{ $lang }}" dir="{{ $lang == 'en' ? 'ltr' : 'rtl' }}"
    style="font-family: {{ $lang == 'en' ? 'Inter, sans-serif' : 'Noto Kufi Arabic, sans-serif' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>British Body</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/logo/logo.png') }}">

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap" rel="stylesheet">

    <!-- Icons -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Styles -->
    @if ($lang == 'en')
    <!-- Bootstrap LTR (default) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @else
    <!-- Bootstrap RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Additional CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />



    <style>
              * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f8f9fa;
            color: #333;
            transition: filter 0.3s ease;



            font-family: {
                 ! ! $lang=='en'? "'Inter', sans-serif": "'Noto Kufi Arabic', sans-serif" ! !
            }

             !important;
        }

        /* Apply font to everything except Font Awesome icons */
        body *:not(.fa):not(.fas):not(.far):not(.fal):not(.fab) {
            font-family: inherit !important;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

    </style>

</head>

<body>

    <!-- Include Modals -->
    @include('website_commerce.header_component.login')
    @include('website_commerce.header_component.register')
    @include('website_commerce.header_component.order_by_app')

    <!-- Top Navbar -->
    @include('website_commerce.header_component.top_nav')

    <!-- Secondary Navbar -->
    @include('website_commerce.header_component.seconadry_nav')

