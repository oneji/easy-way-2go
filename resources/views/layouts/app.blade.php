<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Панель администратора &middot; {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif !important;
        }
    </style>

    @section('head')
        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    @show
</head>

<body data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="{{ route('home') }}" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/logo-light.svg') }}" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('assets/images/logo-light.svg') }}" alt="" height="17">
                            </span>
                        </a>

                        <a href="{{ route('home') }}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/logo-light.svg') }}" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('assets/images/logo-light.svg') }}" alt="" height="35">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>

                <div class="d-flex">
                    <div class="dropdown d-none d-lg-inline-block ml-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="bx bx-fullscreen"></i>
                        </button>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if (Auth::user()->photo !== null)
                                <img class="rounded-circle header-profile-user" src="{{ asset('storage/'.Auth::user()->photo) }}" alt="{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}">
                            @else
                                <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/users/no-photo.png') }}" alt="{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}">
                            @endif
                            <span class="d-none d-xl-inline-block ml-1">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="dropdown-item text-danger" 
                                href="#">
                                <i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i> Выйти
                            </a>

                            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                @csrf
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">Меню</li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-book-open"></i>
                                <span>Справочники</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('admin.de.index') }}">Водительский опыт</a></li>
                                <li><a href="{{ route('admin.carBrands.index') }}">Марки транспорта</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-user-circle"></i>
                                <span>Пользователи</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('admin.brigadirs.index') }}">Бригадиры</a></li>
                                <li><a href="{{ route('admin.drivers.index') }}">Водители</a></li>
                                <li><a href="{{ route('admin.clients.index') }}">Клиенты</a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::segment(1) === 'transport' ? 'mm-active' : null }}">
                            <a href="{{ route('admin.transport.index') }}" class="waves-effect {{ Request::segment(1) === 'transport' ? 'active' : null }}" aria-expanded="false">
                                <i class="bx bx-car"></i>
                                <span>Транспорт</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                @if (isset($breadcrumbs['title']))
                                    <h4 class="mb-0 font-size-18">{{ $breadcrumbs['title'] }}</h4>         
                                @endif

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
                                        @if (isset($breadcrumbs['items']))
                                            @foreach ($breadcrumbs['items'] as $item)
                                                @if ($item['link'] !== null)
                                                    <li class="breadcrumb-item"><a href="{{ $item['link'] }}">{{ $item['name'] }}</a></li>
                                                @else
                                                    <li class="breadcrumb-item active">{{ $item['name'] }}</li>
                                                @endif
                                            @endforeach                                            
                                        @endif
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    @yield('content')

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            {{ now()->year }} © {{ config('app.name') }}
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    @section('scripts')
        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

        <script src="{{ asset('assets/js/app.js') }}"></script>
    @show
</body>
</html>