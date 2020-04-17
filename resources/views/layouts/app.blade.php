<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('css/select2-bootstrap4.min.css') }}" rel="stylesheet" />
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                            @role('patient')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('patient.appointments.create') }}">{{ __('Book Appointment') }}</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('patient.appointments.index') }}">{{ __('VIew Booking') }}</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('patient.doctors.index') }}">{{ __('Search Doctor') }}</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Feedback') }}</a>
                                </li>
                            @endrole

                            @role('doctor')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('doctor.appointments.index') }}">{{ __('My Appointments') }}</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('doctor.patient.show') }}">{{ __('View Patient') }}</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('doctor.treatments.create') }}">{{ __('Add Treatment') }}</a>
                                </li>
                            @endrole
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @auth
                                        @role('patient')
                                            <a class="dropdown-item" href="{{ route('patient.profile.edit', auth()->user()->profile->id) }}">
                                                {{ __('Profile') }}
                                            </a>
                                        @endrole

                                        @role('doctor')
                                            <a class="dropdown-item" href="{{ route('doctor.profile.edit', auth()->user()->profile->id) }}">
                                                {{ __('Profile') }}
                                            </a>
                                        @endrole
                                    @endauth
                                    
                                    
                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>  
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script
        src="https://code.jquery.com/jquery-1.12.4.min.js"
        integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    @include('sweetalert::alert')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>
    @stack('scripts')
</body>
</html>
