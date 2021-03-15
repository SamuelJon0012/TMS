<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@if (trim($__env->yieldContent('template_title')))@yield('template_title') | @endif {{ config('app.name', 'Laravel') }}</title>

        {{-- Styles --}}
        @if(config('laravelusers.enableBootstrapCssCdn'))
            <link rel="stylesheet" type="text/css" href="{{ config('laravelusers.bootstrapCssCdn') }}">
        @endif
        @if(config('laravelusers.enableAppCss'))
            <link rel="stylesheet" type="text/css" href="{{ asset(config('laravelusers.appCssPublicFile')) }}">
        @endif

        @yield('template_linked_css')

        {{-- Scripts --}}
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>
        <style>
            .flags-png{
                width: 32px;
            }
            #dropdownMenuLink{
                box-shadow: none;
            }
        </style>
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
                <div class="container">
                    <a class="navbar-brand small-logo" href="{{ url('/') }}">
                        <img src="logo.jpg" style="height:48px;"/>
                    </a>
                        <!-- Left Side Of Navbar -->

                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/roles') }}">{{ __('Roles') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                        </li>
                    </ul>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">


                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">

                            <!-- Authentication Links -->
                            @guest
                                <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                                <li><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                            @else
                                <li><a class="nav-link" href="{{ route('users') }}">{!! trans('laravelusers::app.nav.users') !!}</a></li>
                                <li>
                                    <div class="dropdown">
                                        <a class="btn dropdown-toggle flags-item" href="#"  role="button" id="dropdownMenuLink" onclick="openDropdown()" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <img src='{{asset("images/en.png")}}' id="en" class="flags-png parent_lang_img" >
                                            <span class="parent_lang">{{ __('English') }}</span>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-lang" aria-labelledby="dropdownMenuLink">
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
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            Logout
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

        {{-- Scripts --}}
        @if(config('laravelusers.enablejQueryCdn'))
            <script src="{{ asset(config('laravelusers.jQueryCdn')) }}"></script>
        @endif
        @if(config('laravelusers.enableBootstrapPopperJsCdn'))
            <script src="{{ asset(config('laravelusers.bootstrapPopperJsCdn')) }}"></script>
        @endif
        @if(config('laravelusers.enableBootstrapJsCdn'))
            <script src="{{ asset(config('laravelusers.bootstrapJsCdn')) }}"></script>
        @endif
        @if(config('laravelusers.enableAppJs'))
            <script src="{{ asset(config('laravelusers.appJsPublicFile')) }}"></script>
        @endif
        @include('laravelusers::scripts.toggleText')

        @yield('template_scripts')
        <script>
            function changeLang(lang){
                let parentFlag = document.getElementsByClassName('parent_lang_img');
                let parentLang = document.getElementsByClassName('parent_lang');
                let clickLang = document.getElementsByClassName(lang)[0].textContent;
                parentFlag[0].src = 'images/' + lang + '.png';
                parentLang[0].innerHTML = clickLang;
                document.getElementsByClassName('dropdown-menu-lang')[0].style.display = 'none';

            }
            function openDropdown() {
                document.getElementsByClassName('dropdown-menu-lang')[0].style.display = 'block';
            }
            window.onclick = function(event) {
                let className = event.target.className;
                if(!className.includes("flags-item")){
                    document.getElementsByClassName('dropdown-menu-lang')[0].style.display = 'none';
                }
            }
            document.addEventListener("DOMContentLoaded", function(event) {
                let local = "{{app()->getlocale()}}"
                changeLang(local);


            });
        </script>
    </body>
</html>
