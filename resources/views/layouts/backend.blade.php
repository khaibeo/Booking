<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>IMTA Booking</title>

    <meta name="description" content="IMTA Booking">
    <meta name="author" content="IMTA">
    <meta name="robots" content="index, follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
    <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">

    <!-- Modules -->
    @yield('css')
    @vite(['resources/sass/main.scss', 'resources/js/dashmix/app.js'])

    @yield('js')
</head>

<body>
    @include('layouts.parts.backend.notification')

    <div id="page-container"
        class="sidebar-o enable-page-overlay sidebar-dark side-scroll page-header-fixed main-content-narrow">
        <!-- Side Overlay-->
        @include('layouts.parts.backend.aside')
        <!-- END Side Overlay -->

        <!-- Sidebar -->
        @include('layouts.parts.backend.sidebar')
        <!-- END Sidebar -->

        <!-- Header -->
        @include('layouts.parts.backend.header')
        <!-- END Header -->

        <!-- Main Container -->
        <main id="main-container">
            @yield('content')
        </main>
        <!-- END Main Container -->

        <!-- Footer -->
        @include('layouts.parts.backend.footer')
        <!-- END Footer -->
    </div>
    <!-- END Page Container -->
    @include('layouts.parts.backend.script')

</body>
</html>
