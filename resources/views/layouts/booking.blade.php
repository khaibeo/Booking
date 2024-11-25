<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name'))</title>

    <meta name="description" content="Dashmix - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="index, follow">

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
    <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">

    <!-- Modules -->
    @yield('css')
    @vite(['resources/sass/main.scss', 'resources/js/dashmix/app.js'])

    <!-- Alternatively, you can also include a specific color theme after the main stylesheet to alter the default color theme of the template -->
    {{-- @vite(['resources/sass/main.scss', 'resources/sass/dashmix/themes/xwork.scss', 'resources/js/dashmix/app.js']) --}}
    @yield('js')
</head>

<body>
    <header
        class="d-flex flex-column flex-md-row justify-content-between align-items-center p-3 px-md-4 mb-3 bg-primary border-bottom box-shadow">
        <div id="logo" class="my-0 mr-md-auto font-weight-normal">
            <a href="{{ route('choose-store') }}">
                <img class="img mw-100" src="{{ Storage::url($settings->logo) }}" height="50px" alt="">
            </a>
        </div>
        <nav class="my-2 my-md-0 mr-md-3">
            @if (!empty($settings->contact_phone))
                <a class="btn btn-alt-secondary" href="#" dat-bs-toggle="tooltip" title="Số điện thoại">
                    <i class="fas fa-fw fa-phone text-success"></i> {{ $settings->contact_phone }}
                </a>
            @endif

            <!-- Facebook -->
            @if (!empty($settings->facebook))
                <a class="btn btn-alt-secondary text-primary" href="{{ $settings->facebook }}" data-bs-toggle="tooltip"
                    title="Facebook">
                    <i class="fab fa-facebook"></i>
                </a>
            @endif

            <!-- Email -->
            @if (!empty($settings->email))
                <a class="btn btn-alt-secondary text-muted" href="mailto:{{ $settings->email }}"
                    data-bs-toggle="tooltip" title="Email">
                    <i class="fas fa-envelope"></i>
                </a>
            @endif

            <!-- Messenger -->
            @if (!empty($settings->messenger))
                <a class="btn btn-alt-secondary text-primary" href="{{ $settings->messenger }}"
                    data-bs-toggle="tooltip" title="Messenger">
                    <i class="fab fa-facebook-messenger"></i>
                </a>
            @endif

            <!-- Zalo -->
            @if (!empty($settings->zalo))
                <a class="btn btn-alt-secondary text-info" href="{{ $settings->zalo }}" data-bs-toggle="tooltip"
                    title="Zalo">
                    <i class="fas fa-comment-dots"></i>
                </a>
            @endif

            <!-- YouTube -->
            @if (!empty($settings->youtube))
                <a class="btn btn-alt-secondary text-danger" href="{{ $settings->youtube }}" data-bs-toggle="tooltip"
                    title="YouTube">
                    <i class="fab fa-youtube"></i>
                </a>
            @endif

            <!-- TikTok -->
            @if (!empty($settings->tiktok))
                <a class="btn btn-alt-secondary text-dark" href="{{ $settings->tiktok }}" data-bs-toggle="tooltip"
                    title="TikTok">
                    <i class="fab fa-tiktok"></i>
                </a>
            @endif

            <!-- Instagram -->
            @if (!empty($settings->instagram))
                <a class="btn btn-alt-secondary text-danger" href="{{ $settings->instagram }}" data-bs-toggle="tooltip"
                    title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
            @endif

            <!-- LinkedIn -->
            @if (!empty($settings->linkedin))
                <a class="btn btn-alt-secondary text-primary" href="{{ $settings->linkedin }}" data-bs-toggle="tooltip"
                    title="LinkedIn">
                    <i class="fab fa-linkedin"></i>
                </a>
            @endif
        </nav>
    </header>
    @yield('booking')
    <!-- Footer -->
    <footer id="page-footer" class="bg-body-light">
        <div class="content py-0">
            <div class="row fs-sm">
                <div class="col-sm-6 order-sm-2 mb-1 mb-sm-0 text-center text-sm-end">
                    Crafted with <i class="fa fa-heart text-danger"></i> by <a class="fw-semibold"
                        href="https://pixelcave.com" target="_blank">pixelcave</a>
                </div>
                <div class="col-sm-6 order-sm-1 text-center text-sm-start">
                    <a class="fw-semibold" href="https://pixelcave.com/products/dashmix" target="_blank">Dashmix 5.8</a>
                    &copy; <span data-toggle="year-copy"></span>
                </div>
            </div>
        </div>
    </footer>
    <!-- END Footer -->

    @yield('scripts')
</body>

</html>
