<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng nhập</title>

    @vite(['resources/sass/main.scss', 'resources/js/dashmix/app.js'])
</head>

<body>
    <body>
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
                                            <span class="text-dark">ĐĂNG NHẬP</span>
                                        </a>
                                        <p class="text-uppercase fw-bold fs-sm text-muted">Trang quản trị</p>
                                    </div>
                                    <!-- END Header -->

                                    <form class="js-validation-signin" action="{{route('login.post')}}" method="POST">
                                        <div class="mb-4">
                                            <div class="input-group input-group-lg">
                                                <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="login-username"
                                                    name="email" placeholder="Email" value="{{ old('email') }}">
                                                <span class="input-group-text">
                                                    <i class="fa fa-user-circle"></i>
                                                </span>
                                                @error('email')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="input-group input-group-lg">
                                                <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="login-password"
                                                    name="password" placeholder="Password">
                                                <span class="input-group-text">
                                                    <i class="fa fa-asterisk"></i>
                                                </span>
                                                @error('password')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div
                                            class="d-sm-flex justify-content-sm-between align-items-sm-center text-center text-sm-start mb-4">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="remember-me"
                                                    name="remember-me" value="1">
                                                <label class="form-check-label" for="remember-me">Ghi nhớ
                                                    tôi</label>
                                            </div>
                                            <div class="fw-semibold fs-sm py-1">
                                                <a href="javascript:void(0)">Quên mật khẩu?</a>
                                            </div>
                                        </div>
                                        <div class="text-center mb-4">
                                            <button type="submit" class="btn btn-hero btn-primary">
                                                <i class="fa fa-fw fa-sign-in-alt opacity-50 me-1"></i> Đăng nhập
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
    </body>
</body>

</html>
