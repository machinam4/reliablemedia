<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $appName = config('app.name', 'Smart Choice');
    @endphp
    <title>@yield('page_name') | {{ str_replace('_', ' ', $appName) }}</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/iconly/bold.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg" type="image/x-icon') }}">

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    @livewireStyles


    @yield('pageCss')
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo">
                            <h2>{{ str_replace('_', ' ', $appName) }}</h2>
                            {{-- <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo" srcset=""></a> --}}
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i
                                    class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>

                        <li class="sidebar-item  ">
                            <a href="{{ Route('dashboard') }}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item  ">
                            <a href="{{ Route('players') }}" class='sidebar-link'>
                                <i class="bi bi-people-fill"></i>
                                <span>Players</span>
                            </a>
                        </li>
                        <li class="sidebar-item  ">
                            <a href="{{ Route('winners') }}" class='sidebar-link'>
                                <i class="bi bi-people-fill"></i>
                                <span>Winners</span>
                            </a>
                        </li>

                        @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Developer')
                            <li class="sidebar-item  ">
                                <a href="{{ Route('sms') }}" class='sidebar-link'>
                                    <i class="bi bi-chat-right-dots-fill"></i>
                                    <span>SMS</span>
                                </a>
                            </li>
                            <li class="sidebar-item  ">
                                <a href="{{ Route('radio') }}" class='sidebar-link'>
                                    <i class="bi bi-broadcast"></i>
                                    <span>Radios</span>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->role == 'Developer')
                            <li class="sidebar-item  ">
                                <a href="{{ Route('mpesa') }}" class='sidebar-link'>
                                    <i class="bi bi-wallet-fill"></i>
                                    <span>MPESA</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main" class='layout-navbar'>
            <header class='mb-3'>
                <nav class="navbar navbar-expand navbar-light ">
                    <div class="container-fluid">
                        <a href="#" class="burger-btn d-block">
                            <i class="bi bi-justify fs-3"></i>
                        </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <ul class="navbar-nav ms-auto">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                        {{-- mail and notifications --}}
                                    </ul>
                                    <div class="dropdown">
                                        <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                            <div class="user-menu d-flex">
                                                <div class="user-name text-end me-3">
                                                    <h6 class="mb-0 text-gray-600">{{ Auth::user()->name }}</h6>
                                                    <p class="mb-0 text-sm text-gray-600">{{ Auth::user()->role }}</p>
                                                </div>
                                                <div class="user-img d-flex align-items-center">
                                                    <div class="avatar avatar-md">
                                                        <img src="assets/images/faces/1.jpg">
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                                            style="min-width: 11rem;">
                                            <li>
                                                <h6 class="dropdown-header">Hello, {{ Auth::user()->username }}!</h6>
                                            </li>
                                            <li><a class="dropdown-item" href="#"><i
                                                        class="icon-mid bi bi-person me-2"></i>
                                                    My
                                                    Profile</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                                                                                                                                                document.getElementById('logout-form').submit();"><i
                                                        class="icon-mid bi bi-box-arrow-left me-2"></i>
                                                    {{ __('Logout') }}</a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    class="d-none">
                                                    @csrf
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            @endguest
                        </ul>
                        <!---->
                    </div>
                </nav>
            </header>
            <div id="main-content">

                @yield('contents')

                <footer>
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start">
                            <p>{{ date('Y') }} &copy; {{ str_replace('_', ' ', $appName) }}</p>
                        </div>
                        <div class="float-end">
                            <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                                by <a href="https://evoton.co.ke">Evoton</a></p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script>
    <script src="assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="{{ asset('assets/js/mazer.js') }}"></script>
    @livewireScripts
    @yield('pageJs')
</body>

</html>
