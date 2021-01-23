@extends('layouts.app')

@section('content')
<div class="container">
  <div class="text-center">
    <img src = "https://trackmyapp.us/images/trackmysolutionslogoregtm-web.jpg">
  </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
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
                            <div class="col-md-8 text-center">
                                <b>{{ __("Forgot your password?") }}</b>
                                <br>
                                {{ __("We just need a few details from to get started.") }}
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('EMail') }}</label> -->

                            <div class="col-md-8 text-center">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('EMail') }}">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('EMail') }}</label> -->

                            <div class="col-md-8 text-center">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus placeholder="{{ __('First Name') }}">

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('EMail') }}</label> -->

                            <div class="col-md-8 text-center">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus placeholder="{{ __('Last Name') }}">

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('EMail') }}</label> -->

                            <div class="col-md-8 text-center">
                                <input id="date_of_birth" type="text" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" required autocomplete="date_of_birth" autofocus placeholder="{{ __('Date Of Birth (MM/DD/YYYY)') }}" onfocus="(this.type='date')">

                                @error('date_of_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row  justify-content-center">
                            <div class="col-md-8  text-center">
                                <br><br>
                                <button type="submit" class="btn btn-primary form-control">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
