<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/custom.js') }}" defer></script>
    <script src="{{ asset('js/moment.min.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <style type="text/css">
    @yield('styleCss')
    </style>
    @stack('pageHeader')
    <style>
        .flags-png{
            width: 32px;
        }
        #dropdownMenuLink{
            box-shadow: none;
        }
        .language-dropdown{
            display: none;
        }
    </style>
</head>
<body
    @if(isset($positive) && $positive) class="positive-page"@endif
    @if(isset($negative) && $negative) class="negative-page"@endif
>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand small-logo" href="{{ url('/') }}">
			             <img src="{{ asset('images/logo.jpg') }}" style="height:48px;" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @if(Auth::check() && Auth::user()->hasRole('admin') )
                        <ul class="navbar-nav mr-auto">
                            @if(!Route::is('dashboard'))
                                @if(Route::is('laravelroles::roles.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="/users">{{ __('Users') }}</a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link" href="/dashboard">{{ __('Dashboard') }}</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="/users">{{ __('Users') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/roles">{{ __('Roles') }}</a>
                                </li>
                            @endif
                        </ul>
                    @endif
                    <div class="dropdown language-dropdown">
                        <a class="btn dropdown-toggle flags-item " href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src='{{asset("/images/en.png")}}' id="en" class="flags-png parent_lang_img">
                            <span class="parent_lang">{{ __('English') }}</span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item flags-item"  href="{{ url('/change-locale/en') }}" onclick="changeLang('en')">
                                <img src='{{asset("images/en.png")}}' id="en" class="flags-png">
                                <span class="en">{{ __('English') }}</span>
                            </a>
                            <a class="dropdown-item flags-item" href="{{ url('/change-locale/es') }}" onclick="changeLang('es')">
                                <img src='{{asset("images/es.png")}}' id="es" class="flags-png" >
                                <span class="es">{{ __('Spanish') }}</span>
                            </a>
                        </div>
                    </div>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-3">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>

                        @else


                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
{{--                                    <a class="dropdown-item" href="{{ route('profile.edit',Auth::user()->id) }}">--}}
{{--                                        {{ __('My Profile') }}--}}
{{--                                    </a>--}}
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script>
    @yield('scriptJs')
    </script>

    @include('app.js')
    @include('app.css')
    @include('app.page_modals')

    @if(Auth::check() && Auth::user()->hasRole('patient'))
    @include('app.patient_modals')
    @include('app.patient_js')
    @endif

    @if(Auth::check() && Auth::user()->hasRole('provider'))
    @include('app.provider_modals')
    @include('app.provider_js')
    @endif

    <div id="preloader" style="display:none;">

        <img src="/preloader.gif">

    </div>

<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script>
        function changeLang(lang){

            if( document.getElementsByClassName(lang)[0] ){
                let parentFlag = document.getElementsByClassName('parent_lang_img');
                let parentLang = document.getElementsByClassName('parent_lang');
                let clickLang = document.getElementsByClassName(lang)[0].textContent;
                parentFlag[0].src = 'images/' + lang + '.png';
                parentLang[0].innerHTML = clickLang;
                return true;
            }

        }
        document.addEventListener("DOMContentLoaded", function(event) {
            let local = "{{app()->getlocale()}}";
            changeLang(local);
            setTimeout(function(){
                document.getElementsByClassName('language-dropdown')[0].style.display = 'block';
            }, 0);
        });
    </script>
@stack('pageBottom')

</body>
</html>
