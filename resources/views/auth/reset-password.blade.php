<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đặt lại mật khẩu</title>

    @vite(['resources/sass/main.scss', 'resources/js/dashmix/app.js'])
</head>

<body>

    <body>
        @include('layouts.parts.backend.notification')

        <div id="page-container">
            <!-- Main Container -->
            <main id="main-container">

                <!-- Page Content -->
                <div class="bg-image">
                    <div class="row g-0 justify-content-center bg-primary-dark-op">
                        <div class="hero-static col-sm-8 col-md-6 col-xl-4 d-flex align-items-center p-2 px-sm-0">
                            <!-- Sign In Block -->
                            <div class="block block-transparent block-rounded w-100 mb-0 overflow-hidden">
                                <div
                                    class="block-content block-content-full px-lg-5 px-xl-6 py-4 py-md-5 py-lg-6 bg-body-extra-light">
                                    <!-- Header -->
                                    <div class="mb-3 text-center">
                                        <a class="link-fx fw-bold fs-1">
                                            <span class="text-dark">ĐẶT LẠI MẬT KHẨU</span>
                                        </a>
                                        <p class="text-uppercase fw-bold fs-sm text-muted">Trang quản trị</p>
                                    </div>
                                    <!-- END Header -->

                                    <form class="js-validation-signin" action="{{ route('password.update') }}"
                                        method="POST">
                                        <div class="mb-4">
                                            <div class="input-group input-group-lg">
                                                <input type="email"
                                                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                    id="login-username" name="email" placeholder="Email của bạn"
                                                    value="{{ old('email') }}">
                                                <span class="input-group-text">
                                                    <i class="fa fa-user-circle"></i>
                                                </span>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <div class="input-group input-group-lg">
                                                <input type="password"
                                                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                                    id="login-username" name="password" placeholder="Mật khẩu mới"
                                                    value="{{ old('password') }}">
                                                <span class="input-group-text">
                                                    <i class="fa fa-asterisk"></i>
                                                </span>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <div class="input-group input-group-lg">
                                                <input type="password"
                                                    class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                                    id="password_confirmation"
                                                    name="password_confirmation" placeholder="Nhập lại mật khẩu">
                                                <span class="input-group-text">
                                                    <i class="fa fa-asterisk"></i>
                                                </span>
                                                @error('password_confirmation ')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <input type="hidden" name="token" value="{{ $token }}">

                                        <div class="text-center mb-4">
                                            <button type="submit" class="btn btn-hero btn-primary">
                                                <i class="fa fa-fw fa-sign-in-alt opacity-50 me-1"></i> Đặt lại mật khẩu
                                            </button>
                                        </div>
                                        @csrf
                                    </form>
                                    <!-- END Sign In Form -->
                                </div>
                            </div>
                            <!-- END Sign In Block -->
                        </div>
                    </div>
                </div>
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->
        </div>
        <!-- END Page Container -->

        @include('layouts.parts.backend.script')
    </body>
</body>

</html>
