@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <!-- <div class="card-header">{{ __('Reset Password') }}</div> -->

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row justify-content-center">
                            <div class="col-md-10 text-center">
                                <h4><b>{{ __("Forgot your password?") }}</b></h4>
                                {{ __("We just need a few details from to get started.") }}
                            </div>
                        </div>

                        <br>
                        <div class="form-group row justify-content-center">
                            <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('EMail') }}</label> -->

                            <div class="col-md-10 text-center">
                                <input id="email" type="email" class="form-control-blue @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('Email') }}">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('EMail') }}</label> -->

                            <div class="col-md-10 text-center">
                                <input id="first_name" type="text" class="form-control-blue @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus placeholder="{{ __('First Name') }}">

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('EMail') }}</label> -->

                            <div class="col-md-10 text-center">
                                <input id="last_name" type="text" class="form-control-blue @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus placeholder="{{ __('Last Name') }}">

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('EMail') }}</label> -->

                            <div class="col-md-10 text-center">
                                <input id="date_of_birth" type="text" class="form-control-blue @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" required autocomplete="date_of_birth" autofocus placeholder="{{ __('Date Of Birth (MM/DD/YYYY)') }}" onfocus="(this.type='date')">

                                @error('date_of_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row  justify-content-center">
                            <div class="col-md-10  text-center">
                                <br><br>
                                <button type="submit" class="btn btn-primary form-control">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
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
        <a href="https://trackmyapp.us/files/default/terms.html" target="_blank">Terms</a>
        |
        <a href="https://trackmyapp.us/files/default/terms.html" target="_blank">Privacy policy</a>
        ]

    </div>
</div>
@endsection
