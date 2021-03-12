<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .code {
                border-right: 2px solid;
                font-size: 26px;
                padding: 0 15px 0 15px;
                text-align: center;
            }

            .message {
                font-size: 18px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
{{--            <div class="code">--}}
{{--                @yield('code')--}}
{{--            </div>--}}
            <div class="message" style="padding: 10px;">
                @yield('code') - @yield('message')
                <br/>
                <br/>
                {{ __('Please try going') }} <a href="/home">{{ __('back to the dashboard') }}</a>{{ __(', or') }} <a href="/login">{{ __('log in again') }}</a>{{ __('. If the problem persists please contact support.') }}
                <br/>
                <br/>
                <h4>{{ __('Patient Call Center: 1-844-522-5952') }}</h4>
                <br/>
                <br/>
                {{ __('9am-5pm 7 days a week EST') }}
            </div>
        </div>

    </body>

</html>
