@extends('layouts.app')
@section('scriptJs')


        $(document).ready(function() {

            $('.cover-page-modal').show();

            $('.navbar-nav').hide();

        });

@endsection

@section('content')
<div class="container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                <!-- <div class="card-header">{{ __('Reset Password') }}</div> -->

                    <div class="card-body">

{{--                        <form method="POST" action="/vaccine">--}}
{{--                            @csrf--}}

{{--                            <div class="form-group row justify-content-center">--}}
{{--                                <div class="col-md-10 text-center">--}}
{{--                                    <h4><b>{{ __("Get Notified") }}</b></h4>--}}
{{--                                    {{ __("Be notified when you will be eligible for the COVID-19 vaccine") }}--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <br>--}}
{{--                            <div class="form-group row justify-content-center">--}}
{{--                                <div class="col-md-10 text-center">--}}
{{--                                    <input id="email" type="email" class="form-control-blue" required autocomplete="email" autofocus placeholder="{{ __('EMail') }}">--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="form-group row justify-content-center">--}}
{{--                                <div class="col-md-10 text-center">--}}
{{--                                    <input id="phone" type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" class="form-control-blue" required autocomplete="phone" autofocus placeholder="{{ __('US Phone ###-###-####') }}">--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="form-group row justify-content-center">--}}
{{--                                <div class="col-md-10 text-center">--}}
{{--                                    <input id="first_name" type="text" class="form-control-blue" name="first_name" required autocomplete="first_name" autofocus placeholder="{{ __('First Name') }}">--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="form-group row justify-content-center">--}}
{{--                                <div class="col-md-10 text-center">--}}
{{--                                    <input id="last_name" type="text" class="form-control-blue" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus placeholder="{{ __('Last Name') }}">--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="form-group row justify-content-center">--}}
{{--                                <div class="col-md-10 text-center">--}}
{{--                                    <input id="date_of_birth" type="text" class="form-control-blue" name="date_of_birth" value="{{ old('date_of_birth') }}" required autocomplete="date_of_birth" autofocus placeholder="{{ __('Date Of Birth (MM/DD/YYYY)') }}" onfocus="(this.type='date')">--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="form-group row  justify-content-center">--}}
{{--                                <div class="col-md-10  text-center">--}}
{{--                                    <br><br>--}}
{{--                                    <button type="submit" class="btn btn-primary form-control">--}}
{{--                                        {{ __('Please Inform Me') }}--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
                    </div>
                    <br>

                </div>
            </div>
        </div>
        <br/>
        <div class="text-center">
            <img src = "{{ asset('images/trackmysolutionslogoregtm-web.jpg') }}">
            <br/>
            [
            <a href="https://trackmyapp.us/files/default/terms.html" target="_blank">{{ __('Terms') }}</a>
            |
            <a href="https://trackmyapp.us/files/default/terms.html" target="_blank">{{ __('Privacy policy') }}</a>
            ]
        </div>
    </div>

</div>

@endsection
