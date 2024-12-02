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

  <!-- Alternatively, you can also include a specific color theme after the main stylesheet to alter the default color theme of the template -->
  {{-- @vite(['resources/sass/main.scss', 'resources/sass/dashmix/themes/xwork.scss', 'resources/js/dashmix/app.js']) --}}
  @yield('js')
</head>

<body>
    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Dashmix.helpers('jq-notify', {
                type: 'success',
                icon: 'fa fa-check me-1',
                message: '{{ session('success') }}'
            });
        });
    </script>
  @endif

  @if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Dashmix.helpers('jq-notify', {
                type: 'danger',
                icon: 'fa fa-times me-1',
                message: '{{ session('error') }}'
            });
        });
    </script>
  @endif
  <div id="page-container" class="sidebar-o enable-page-overlay sidebar-dark side-scroll page-header-fixed main-content-narrow">
    <!-- Side Overlay-->
    <aside id="side-overlay">
      <!-- Side Header -->
      <div class="bg-image" style="background-image: url('{{ asset('media/various/bg_side_overlay_header.jpg') }}');">
        <div class="bg-primary-op">
          <div class="content-header">
            <!-- User Avatar -->
            <a class="img-link me-1" href="javascript:void(0)">
              <img class="img-avatar img-avatar48" src="{{ asset('media/avatars/avatar10.jpg') }}" alt="">
            </a>
            <!-- END User Avatar -->

            <!-- User Info -->
            <div class="ms-2">
              <a class="text-white fw-semibold" href="javascript:void(0)">George Taylor</a>
              <div class="text-white-75 fs-sm">Full Stack Developer</div>
            </div>
            <!-- END User Info -->

            <!-- Close Side Overlay -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <a class="ms-auto text-white" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_close">
              <i class="fa fa-times-circle"></i>
            </a>
            <!-- END Close Side Overlay -->
          </div>
        </div>
      </div>
      <!-- END Side Header -->

      <!-- Side Content -->
      <div class="content-side">
        <div class="block pull-x mb-0">
          <!-- Sidebar -->
          <div class="block-content block-content-sm block-content-full bg-body">
            <span class="text-uppercase fs-sm fw-bold">Sidebar</span>
          </div>
          <div class="block-content block-content-full">
            <div class="row g-sm text-center">
              <div class="col-6 mb-1">
                <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="sidebar_style_dark" href="javascript:void(0)">Dark</a>
              </div>
              <div class="col-6 mb-1">
                <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="sidebar_style_light" href="javascript:void(0)">Light</a>
              </div>
            </div>
          </div>
          <!-- END Sidebar -->

          <!-- Header -->
          <div class="block-content block-content-sm block-content-full bg-body">
            <span class="text-uppercase fs-sm fw-bold">Header</span>
          </div>
          <div class="block-content block-content-full">
            <div class="row g-sm text-center mb-2">
              <div class="col-6 mb-1">
                <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="header_style_dark" href="javascript:void(0)">Dark</a>
              </div>
              <div class="col-6 mb-1">
                <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="header_style_light" href="javascript:void(0)">Light</a>
              </div>
              <div class="col-6 mb-1">
                <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="header_mode_fixed" href="javascript:void(0)">Fixed</a>
              </div>
              <div class="col-6 mb-1">
                <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="header_mode_static" href="javascript:void(0)">Static</a>
              </div>
            </div>
          </div>
          <!-- END Header -->

          <!-- Content -->
          <div class="block-content block-content-sm block-content-full bg-body">
            <span class="text-uppercase fs-sm fw-bold">Content</span>
          </div>
          <div class="block-content block-content-full">
            <div class="row g-sm text-center">
              <div class="col-6 mb-1">
                <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="content_layout_boxed" href="javascript:void(0)">Boxed</a>
              </div>
              <div class="col-6 mb-1">
                <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="content_layout_narrow" href="javascript:void(0)">Narrow</a>
              </div>
              <div class="col-12 mb-1">
                <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="content_layout_full_width" href="javascript:void(0)">Full Width</a>
              </div>
            </div>
          </div>
          <!-- END Content -->
        </div>
        <div class="block pull-x mb-0">
          <!-- Content -->
          <div class="block-content block-content-sm block-content-full bg-body">
            <span class="text-uppercase fs-sm fw-bold">Heading</span>
          </div>
          <div class="block-content">
            <p>
              Content..
            </p>
          </div>
          <!-- END Content -->
        </div>
      </div>
      <!-- END Side Content -->
    </aside>
    <!-- END Side Overlay -->

    <!-- Sidebar -->
    <!--
      Sidebar Mini Mode - Display Helper classes

      Adding 'smini-hide' class to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
      Adding 'smini-show' class to an element will make it visible (opacity: 1) when the sidebar is in mini mode
          If you would like to disable the transition animation, make sure to also add the 'no-transition' class to your element

      Adding 'smini-hidden' to an element will hide it when the sidebar is in mini mode
      Adding 'smini-visible' to an element will show it (display: inline-block) only when the sidebar is in mini mode
      Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
    -->
    <nav id="sidebar" aria-label="Main Navigation">
      <!-- Side Header -->
      <div class="bg-header-dark">
        <div class="content-header bg-white-5">
          <!-- Logo -->
          <a class="fw-semibold text-white tracking-wide" href="/">
            <span class="smini-visible">
              D<span class="opacity-75">x</span>
            </span>
            <span class="smini-hidden">
              IMTA<span class="opacity-75">Booking</span>
            </span>
          </a>
          <!-- END Logo -->

          <!-- Options -->
          <div>
            <!-- Toggle Sidebar Style -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <!-- Class Toggle, functionality initialized in Helpers.dmToggleClass() -->
            <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="class-toggle" data-target="#sidebar-style-toggler" data-class="fa-toggle-off fa-toggle-on" onclick="Dashmix.layout('sidebar_style_toggle');Dashmix.layout('header_style_toggle');">
              <i class="fa fa-toggle-off" id="sidebar-style-toggler"></i>
            </button>
            <!-- END Toggle Sidebar Style -->

            <!-- Dark Mode -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="class-toggle" data-target="#dark-mode-toggler" data-class="far fa" onclick="Dashmix.layout('dark_mode_toggle');">
              <i class="far fa-moon" id="dark-mode-toggler"></i>
            </button>
            <!-- END Dark Mode -->

            <!-- Close Sidebar, Visible only on mobile screens -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <button type="button" class="btn btn-sm btn-alt-secondary d-lg-none" data-toggle="layout" data-action="sidebar_close">
              <i class="fa fa-times-circle"></i>
            </button>
            <!-- END Close Sidebar -->
          </div>
          <!-- END Options -->
        </div>
      </div>
      <!-- END Side Header -->

      <!-- Sidebar Scrolling -->
      <div class="js-sidebar-scroll">
        <!-- Side Navigation -->
        <div class="content-side content-side-full">
          <ul class="nav-main">
            {{-- ROLE MANAGER --}}
            @if(auth()->user()->role == 'manager' || auth()->user()->role == 'admin')
            <li class="nav-main-item">
              <a class="nav-main-link{{ request()->is('manager') ? ' active' : '' }}" href="{{ route('admin.dashboard') }}">
                  <i class="nav-main-link-icon fa fa-location-arrow"></i>
                  <span class="nav-main-link-name">Dashboard</span>
              </a>
          </li>
            {{-- STORE --}}
            @can('is-admin')
              <li class="nav-main-item{{ request()->is('admin/stores/*')  || request()->is('admin/stores') ? ' open' : '' }}">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="{{ request()->is('admin/stores/*') ? 'true' : 'false' }}" href="#">
                  <i class="nav-main-link-icon fa fa-store"></i>
                  <span class="nav-main-link-name">Cửa hàng</span>
                </a>
                <ul class="nav-main-submenu{{ request()->is('admin/stores/*') ? ' show' : '' }}">
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('admin/stores/') ? ' active' : '' }}" href="{{ route('admin.stores.index') }}">
                      <span class="nav-main-link-name">Danh sách</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('admin/stores/create') ? ' active' : '' }}" href="{{ route('admin.stores.create') }}">
                      <span class="nav-main-link-name">Thêm mới</span>
                    </a>
                  </li>
                </ul>
              </li>
              @endcan

              @can('is-manager')
              <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('admin.stores.edit', auth()->user()->store_id) }}">
                  <i class="nav-main-link-icon fa fa-store"></i>
                  <span class="nav-main-link-name">Cửa hàng</span>
                </a>
              </li>
              @endcan

              {{-- USERS --}}
              <li class="nav-main-item{{ request()->is('admin/users/*') || request()->is('admin/users') ? ' open' : '' }}">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="{{ request()->is('admin/users/*') ? 'true' : 'false' }}" href="#">
                  <i class="nav-main-link-icon fa fa-user"></i>
                  <span class="nav-main-link-name">Nhân viên</span>
                </a>
                <ul class="nav-main-submenu{{ request()->is('admin/users/*') ? ' show' : '' }}">
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('admin/users') ? ' active' : '' }}" href="{{ route('admin.users.index') }}">
                      <span class="nav-main-link-name">Danh sách</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('admin/users/create') ? ' active' : '' }}" href="{{ route('admin.users.create') }}">
                      <span class="nav-main-link-name">Thêm mới</span>
                    </a>
                  </li>
                </ul>
              </li>

              {{-- Service_Category --}}
              @can('is-admin')
              <li class="nav-main-item{{ request()->is('admin/services_category/*') || request()->is('admin/services_category') ? ' open' : '' }}">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="{{ request()->is('admin/services_category/*') ? 'true' : 'false' }}" href="#">
                    <i class="nav-main-link-icon fa fa-list-ul"></i>
                    <span class="nav-main-link-name">Danh mục</span>
                </a>
                <ul class="nav-main-submenu{{ request()->is('admin/services_category/*') ? ' show' : '' }}">
                    <li class="nav-main-item">
                        <a class="nav-main-link{{ request()->is('admin/services_category') ? ' active' : '' }}" href="{{ route('admin.services_category.index') }}">
                            <span class="nav-main-link-name">Danh sách</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                      <a class="nav-main-link{{ request()->is('admin/services_category/create') ? ' active' : '' }}" href="{{ route('admin.services_category.create') }}">
                        <span class="nav-main-link-name">Thêm mới</span>
                      </a>
                    </li>
                </ul>
              </li>
              @endcan

              @can('is-manager')
              <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('admin.services_category.index') }}">
                  <i class="nav-main-link-icon fa fa-list-ul"></i>
                  <span class="nav-main-link-name">Danh mục</span>
                </a>
              </li>
              @endcan
              {{-- Service --}}
              @can('admin')
              <li class="nav-main-item{{ request()->is('admin/services/*') || request()->is('admin/services') ? ' open' : '' }}">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="{{ request()->is('admin/services/*') ? 'true' : 'false' }}" href="#">
                    <i class="nav-main-link-icon fa fa-clipboard-list"></i>
                    <span class="nav-main-link-name">Dịch vụ</span>
                </a>
                <ul class="nav-main-submenu{{ request()->is('admin/services/*') ? ' show' : '' }}">
                    <li class="nav-main-item">
                        <a class="nav-main-link{{ request()->is('admin/services') ? ' active' : '' }}" href="{{ route('admin.services.index') }}">
                            <span class="nav-main-link-name">Danh sách</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                      <a class="nav-main-link{{ request()->is('admin/services/create') ? ' active' : '' }}" href="{{ route('admin.services.create') }}">
                        <span class="nav-main-link-name">Thêm mới</span>
                      </a>
                    </li>
                </ul>
              </li>
              @endcan

              @can('is-manager')
              <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('admin.services.index') }}">
                  <i class="nav-main-link-icon fa fa-clipboard-list"></i>
                  <span class="nav-main-link-name">Dịch vụ</span>
                </a>
              </li>
              @endcan

              {{-- BOOKING --}}
              <li class="nav-main-item{{ request()->is('admin/bookings/*') || request()->is('admin/bookings') ? ' open' : '' }}">
                <a class="nav-main-link" aria-expanded="{{ request()->is('admin/bookings/*') ? 'true' : 'false' }}" href="{{ route('admin.bookings.index') }}">
                    <i class="nav-main-link-icon fa fa-calendar-check"></i>
                    <span class="nav-main-link-name">Booking</span>
                </a>
              </li>

              @can('viewSetting', App\Models\Setting::class)
              <li class="nav-main-item">
                <a class="nav-main-link" href="{{route('admin.settings.show')}}">
                    <i class="nav-main-link-icon fa fa-cog"></i>
                    <span class="nav-main-link-name">Cài đặt</span>
                </a>
              </li>
              @endcan

            @endif
            {{--ROLE STAFF --}}
            @can('is-staff')
            <li class="nav-main-item">
              <a class="nav-main-link" href="{{ route('admin.staff.dashboard') }}">
                  <i class="nav-main-link-icon fa fa-location-arrow"></i>
                  <span class="nav-main-link-name">Dashboard</span>
              </a>
            </li>
          
              <li class="nav-main-item{{ request()->is('admin/*') || request()->is('admin/') ? ' open' : '' }}">
                  <a class="nav-main-link" aria-haspopup="true" aria-expanded="{{ request()->is('admin/*') ? 'true' : 'false' }}" href="{{ route('admin.staff.bookings.index', auth()->user()->staffId) }}">
                      <i class="nav-main-link-icon fa fa-calendar-check"></i>
                      <span class="nav-main-link-name">Booking</span>
                  </a>
              </li>

              <li class="nav-main-item{{ request()->is('admin/staff/schedules/*') || request()->is('admin/staff/schedules/') ? ' open' : '' }}">
                <a class="nav-main-link" href="{{ route('admin.staff.schedules.index') }}">
                    <i class="nav-main-link-icon fa fa-calendar"></i>
                    <span class="nav-main-link-name">Lịch làm việc</span>
                </a>
            </li>
            @endcan
          </ul>
        </div>
        <!-- END Side Navigation -->
      </div>
      <!-- END Sidebar Scrolling -->
    </nav>
    <!-- END Sidebar -->

    <!-- Header -->
    <header id="page-header">
      <!-- Header Content -->
      <div class="content-header">
        <!-- Left Section -->
        <div class="space-x-1">
          <!-- Toggle Sidebar -->
          <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
          <button type="button" class="btn btn-alt-secondary" data-toggle="layout" data-action="sidebar_toggle">
            <i class="fa fa-fw fa-bars"></i>
          </button>
          <!-- END Toggle Sidebar -->

          <!-- Open Search Section -->
          <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
          {{-- <button type="button" class="btn btn-alt-secondary" data-toggle="layout" data-action="header_search_on">
            <i class="fa fa-fw opacity-50 fa-search"></i> <span class="ms-1 d-none d-sm-inline-block">Search</span>
          </button> --}}
          <!-- END Open Search Section -->
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="space-x-1">
          <!-- User Dropdown -->
          <div class="dropdown d-inline-block">
            <button type="button" class="btn btn-alt-secondary" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-fw fa-user d-sm-none"></i>
              <span class="d-none d-sm-inline-block">{{ auth()->user()->name }}</span>
              <i class="fa fa-fw fa-angle-down opacity-50 ms-1 d-none d-sm-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="page-header-user-dropdown">
              <div class="bg-primary-dark rounded-top fw-semibold text-white text-center p-3">
                Thao tác
              </div>
              <div class="p-2">
                {{-- <a class="dropdown-item" href="javascript:void(0)">
                  <i class="far fa-fw fa-user me-1"></i> Profile
                </a>
                <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                  <span><i class="far fa-fw fa-envelope me-1"></i> Inbox</span>
                  <span class="badge bg-primary rounded-pill">3</span>
                </a>
                <a class="dropdown-item" href="javascript:void(0)">
                  <i class="far fa-fw fa-file-alt me-1"></i> Invoices
                </a> --}}
                <div role="separator" class="dropdown-divider"></div>

                <!-- END Side Overlay -->

                <div role="separator" class="dropdown-divider"></div>
                <form method="POST" action="{{route('logout')}}">
                  <button class="dropdown-item">
                    <i class="far fa-fw fa-arrow-alt-circle-left me-1"></i> Đăng xuất
                  </button>
                  @csrf
                </form>
              </div>
            </div>
          </div>
          <!-- END User Dropdown -->
        </div>
        <!-- END Right Section -->
      </div>
      <!-- END Header Content -->

      <!-- Header Search -->
      <div id="page-header-search" class="overlay-header bg-header-dark">
        <div class="content-header">
          <form class="w-100" action="/dashboard" method="POST">
            @csrf
            <div class="input-group">
              <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
              <button type="button" class="btn btn-alt-primary" data-toggle="layout" data-action="header_search_off">
                <i class="fa fa-fw fa-times-circle"></i>
              </button>
              <input type="text" class="form-control border-0" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
            </div>
          </form>
        </div>
      </div>
      <!-- END Header Search -->

      <!-- Header Loader -->
      <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
      <div id="page-header-loader" class="overlay-header bg-header-dark">
        <div class="bg-white-10">
          <div class="content-header">
            <div class="w-100 text-center">
              <i class="fa fa-fw fa-sun fa-spin text-white"></i>
            </div>
          </div>
        </div>
      </div>
      <!-- END Header Loader -->
    </header>
    <!-- END Header -->

    <!-- Main Container -->
    <main id="main-container">
      @yield('content')
    </main>
    <!-- END Main Container -->

    <!-- Footer -->
    <footer id="page-footer" class="bg-body-light">
      <div class="content py-0">
        <div class="row fs-sm">
          <div class="col-sm-6 order-sm-2 mb-1 mb-sm-0 text-center text-sm-end">
            Crafted with <i class="fa fa-heart text-danger"></i> by <a class="fw-semibold" href="https://caodang.fpt.edu.vn/" target="_blank">FPT Polytechnic students</a>
          </div>
          <div class="col-sm-6 order-sm-1 text-center text-sm-start">
            <a class="fw-semibold" href="https://www.imtatech.com/" target="_blank">IMTA TECH</a> &copy;
            <span data-toggle="year-copy"></span>
          </div>
        </div>
      </div>
    </footer>
    <!-- END Footer -->
  </div>
  <!-- END Page Container -->
    {{-- <script src="{{ asset('assets') }}/js/dashmix.app.min.js"></script> --}}

    <!-- jQuery (required for BS Notify plugin) -->
    <script src="{{ asset('js') }}/lib/jquery.min.js"></script>

    <!-- Page JS Plugins -->
    <script src="{{ asset('js') }}/plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
    <!-- Page JS Helpers (BS Notify Plugin) -->
    <script>
        Dashmix.helpersOnLoad(['jq-notify']);
    </script>

    <script src="{{ asset('js') }}/plugins/sweetalert2/sweetalert2.min.js"></script>

    <!-- Page JS Code -->
    {{-- <script src="{{ asset('js') }}/lib/be_comp_dialogs.js"></script> --}}
</body>

</html>
