@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-6">
            <div class="card">
                <!-- <div class="card-header">{{ __('Login') }}</div> -->
                <br><br>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row justify-content-center">
                            <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> -->

                            <div class="col-md-10">
                                <input id="email" type="email" class="form-control-blue @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('Email Address') }}">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <!-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> -->

                            <div class="col-md-10">
                                @if (Route::has('password.request'))
                                  <div class="text-right">
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                  </div>
                                @endif

                                <input id="password" type="password" class="form-control-blue @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">

                                @error('password')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-10 text-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-10 text-center">
                                <button type="submit" class="btn btn-primary form-control">
                                    {{ __('Sign In') }}
                                </button>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-10 text-center dashes">
                                {{ __("Haven't created an account yet?  ") }}
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-10 text-center">
                                <select id="sel_register" name="sel_register" class="form-control border border-primary" style="text-align-last:center;">
                                  <option value="">{{ __('Register') }}</option>
                                  <option value="patient">{{ __('I am a Patient') }}</option>
                                  <option value="provider">{{ __('I am a Provider') }}</option>
                                </select>
                            </div>
                        </div>

                    </form>
                </div>

                <br><br>
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
