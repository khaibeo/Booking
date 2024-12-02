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
                <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="class-toggle"
                    data-target="#sidebar-style-toggler" data-class="fa-toggle-off fa-toggle-on"
                    onclick="Dashmix.layout('sidebar_style_toggle');Dashmix.layout('header_style_toggle');">
                    <i class="fa fa-toggle-off" id="sidebar-style-toggler"></i>
                </button>
                <!-- END Toggle Sidebar Style -->

                <!-- Dark Mode -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="class-toggle"
                    data-target="#dark-mode-toggler" data-class="far fa" onclick="Dashmix.layout('dark_mode_toggle');">
                    <i class="far fa-moon" id="dark-mode-toggler"></i>
                </button>
                <!-- END Dark Mode -->

                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-sm btn-alt-secondary d-lg-none" data-toggle="layout"
                    data-action="sidebar_close">
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
                @if (auth()->user()->role == 'manager' || auth()->user()->role == 'admin')
                    <li class="nav-main-item">
                        <a class="nav-main-link{{ request()->is('manager') ? ' active' : '' }}"
                            href="{{ route('admin.dashboard') }}">
                            <i class="nav-main-link-icon fa fa-location-arrow"></i>
                            <span class="nav-main-link-name">Dashboard</span>
                        </a>
                    </li>
                    {{-- STORE --}}
                    @can('is-admin')
                        <li
                            class="nav-main-item{{ request()->is('admin/stores/*') || request()->is('admin/stores') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="{{ request()->is('admin/stores/*') ? 'true' : 'false' }}" href="#">
                                <i class="nav-main-link-icon fa fa-store"></i>
                                <span class="nav-main-link-name">Cửa hàng</span>
                            </a>
                            <ul class="nav-main-submenu{{ request()->is('admin/stores/*') ? ' show' : '' }}">
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->is('admin/stores/') ? ' active' : '' }}"
                                        href="{{ route('admin.stores.index') }}">
                                        <span class="nav-main-link-name">Danh sách</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->is('admin/stores/create') ? ' active' : '' }}"
                                        href="{{ route('admin.stores.create') }}">
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
                    <li
                        class="nav-main-item{{ request()->is('admin/users/*') || request()->is('admin/users') ? ' open' : '' }}">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                            aria-expanded="{{ request()->is('admin/users/*') ? 'true' : 'false' }}" href="#">
                            <i class="nav-main-link-icon fa fa-user"></i>
                            <span class="nav-main-link-name">Nhân viên</span>
                        </a>
                        <ul class="nav-main-submenu{{ request()->is('admin/users/*') ? ' show' : '' }}">
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/users') ? ' active' : '' }}"
                                    href="{{ route('admin.users.index') }}">
                                    <span class="nav-main-link-name">Danh sách</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/users/create') ? ' active' : '' }}"
                                    href="{{ route('admin.users.create') }}">
                                    <span class="nav-main-link-name">Thêm mới</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- Service_Category --}}
                    @can('is-admin')
                        <li
                            class="nav-main-item{{ request()->is('admin/services_category/*') || request()->is('admin/services_category') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="{{ request()->is('admin/services_category/*') ? 'true' : 'false' }}"
                                href="#">
                                <i class="nav-main-link-icon fa fa-list-ul"></i>
                                <span class="nav-main-link-name">Danh mục</span>
                            </a>
                            <ul class="nav-main-submenu{{ request()->is('admin/services_category/*') ? ' show' : '' }}">
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->is('admin/services_category') ? ' active' : '' }}"
                                        href="{{ route('admin.services_category.index') }}">
                                        <span class="nav-main-link-name">Danh sách</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->is('admin/services_category/create') ? ' active' : '' }}"
                                        href="{{ route('admin.services_category.create') }}">
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
                        <li
                            class="nav-main-item{{ request()->is('admin/services/*') || request()->is('admin/services') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="{{ request()->is('admin/services/*') ? 'true' : 'false' }}"
                                href="#">
                                <i class="nav-main-link-icon fa fa-clipboard-list"></i>
                                <span class="nav-main-link-name">Dịch vụ</span>
                            </a>
                            <ul class="nav-main-submenu{{ request()->is('admin/services/*') ? ' show' : '' }}">
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->is('admin/services') ? ' active' : '' }}"
                                        href="{{ route('admin.services.index') }}">
                                        <span class="nav-main-link-name">Danh sách</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->is('admin/services/create') ? ' active' : '' }}"
                                        href="{{ route('admin.services.create') }}">
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
                    <li
                        class="nav-main-item{{ request()->is('admin/bookings/*') || request()->is('admin/bookings') ? ' open' : '' }}">
                        <a class="nav-main-link"
                            aria-expanded="{{ request()->is('admin/bookings/*') ? 'true' : 'false' }}"
                            href="{{ route('admin.bookings.index') }}">
                            <i class="nav-main-link-icon fa fa-calendar-check"></i>
                            <span class="nav-main-link-name">Booking</span>
                        </a>
                    </li>

                    @can('viewSetting', App\Models\Setting::class)
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{ route('admin.settings.show') }}">
                                <i class="nav-main-link-icon fa fa-cog"></i>
                                <span class="nav-main-link-name">Cài đặt</span>
                            </a>
                        </li>
                    @endcan
                @endif
                {{-- ROLE STAFF --}}
                @can('is-staff')
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('admin.staff.dashboard') }}">
                            <i class="nav-main-link-icon fa fa-location-arrow"></i>
                            <span class="nav-main-link-name">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-main-item{{ request()->is('admin/*') || request()->is('admin/') ? ' open' : '' }}">
                        <a class="nav-main-link" aria-haspopup="true"
                            aria-expanded="{{ request()->is('admin/*') ? 'true' : 'false' }}"
                            href="{{ route('admin.staff.bookings.index', auth()->user()->staffId) }}">
                            <i class="nav-main-link-icon fa fa-calendar-check"></i>
                            <span class="nav-main-link-name">Booking</span>
                        </a>
                    </li>

                    <li
                        class="nav-main-item{{ request()->is('admin/staff/schedules/*') || request()->is('admin/staff/schedules/') ? ' open' : '' }}">
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
