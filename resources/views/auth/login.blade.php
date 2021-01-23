@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center">
      <img src = "https://trackmyapp.us/images/trackmysolutionslogoregtm-web.jpg">
    </div>

    <div class="row justify-content-center">

        <div class="col-md-6">
            <div class="card">
                <!-- <div class="card-header">{{ __('Login') }}</div> -->

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row justify-content-center">
                            <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> -->

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('Email Address') }}">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <div class="text-right">
                                  <a class="btn btn-link" href="{{ route('/forgotpassword') }}">
                                      {{ __('Forgot Your Password?') }}
                                  </a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <!-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> -->

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-8 text-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-8 text-center">
                                <button type="submit" class="btn btn-primary form-control">
                                    {{ __('Sign In') }}
                                </button>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-8 text-center">
                                {{ __("Haven't created an account yet?") }}
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-8 text-center">
                                <select id="sel_register" name="sel_register" class="form-control border border-primary">
                                  <option value="">{{ __('Register') }}</option>
                                  <option value="patient">{{ __('I am a Patient') }}</option>
                                  <option value="provider">{{ __('I am a Provider') }}</option>
                                </select>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scriptJs')
$(function(){
 $("#sel_register").on('change', function(){
   if($(this).val())
   {
     window.location.href = "/"+$(this).val()+"profile";
   }
 })

});
@endsection
