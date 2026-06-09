<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ config('site.name') }} - {{ $title ?? config('site.tagline') }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="custom software, software development, web application, mobile app, saas, digital marketing, seo" name="keywords">
    <meta content="{{ config('site.name') }} - {{ config('site.tagline') }}" name="description">

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- SPA progress bar -->
    <style>
        #spa-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            width: 0;
            background: var(--bs-primary, #06A3DA);
            box-shadow: 0 0 8px rgba(6, 163, 218, 0.7);
            z-index: 2000;
            opacity: 0;
            transition: width 0.3s ease, opacity 0.3s ease;
        }
        #spa-progress.active {
            opacity: 1;
            width: 85%;
            transition: width 8s cubic-bezier(0.1, 0.7, 0.1, 1), opacity 0.2s ease;
        }
        #spa-main.spa-leaving {
            opacity: 0.55;
            transition: opacity 0.15s ease;
        }
        #spa-main {
            transition: opacity 0.2s ease;
        }
    </style>
</head>

<body>
    <div class="container-fluid bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- SPA swappable region: navbar + header + content -->
        <div id="spa-main">
            <!-- Navbar & Header Start -->
            <div class="container-fluid position-relative p-0">
                @include('partials.navbar')

                @yield('header')
            </div>
            <!-- Navbar & Header End -->

            @yield('content')
        </div>
        <!-- /spa-main -->

        @include('partials.footer')

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top pt-2"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- SPA navigation (no framework, no full reload) -->
    <script src="{{ asset('js/spa.js') }}"></script>
</body>

</html>
