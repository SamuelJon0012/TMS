@extends('admin.layouts.auth')

@section('content')
<form method="POST" class="login-form" action="">
        @csrf
    <div class="card mb-0">
        <a href="" class="changeLocal">
            {{ __('app.registration') }}
        </a>
        <div class="card-body">
            <div class="text-center mb-3">
                <img style="object-fit: scale-down" width="200px" height="200px" src="/assets/images/sp-logo1.png" alt="">
                <h5 class="mb-0">{{ __('admin.Login') }}</h5>
                <span class="d-block text-muted">{{ __('admin.Your_credentials') }}</span>
            </div>

            <div class="form-group form-group-feedback form-group-feedback-left">
                <input type="email"  class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{ __('admin.EMail_Address') }}">
                <div class="form-control-feedback">
                    <i class="icon-user text-muted"></i>
                </div>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group form-group-feedback form-group-feedback-left">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('admin.Password') }}"  autocomplete="current-password">


                <div class="form-control-feedback">
                    <i class="icon-lock2 text-muted"></i>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


            <div class="form-group d-flex align-items-center">
                <div class="form-check mb-0">
                    <label class="form-check-label">
                        <input type="checkbox" name="remember" class="form-input-styled" checked data-fouc>
                        {{ __('admin.Remember_Me') }}
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <a class="ml-auto" style="color: #007433 " href="">
                        {{ __('admin.Forgot_Your_Password') }}
                    </a>
                @endif
            </div>

            <div class="form-group">
                <button type="submit" style="background-color: #007433 " class="btn btn-primary btn-block">{{ __('admin.Login') }}<i class="icon-circle-right2 ml-2"></i></button>
            </div>
        </div>
    </div>
</form>


@endsection
<style>
    .changeLocal{
        position: absolute;
        right: 0;
        max-width: 100px;
        min-width: 100px;
        text-align: center;
        color: black;
        font-weight: bold;
        border: 1.5px solid white;
        background: #fcdc55;
        padding: 7px 21px;
        z-index: 9;
        height: 40px;
        font-size: 13px;
    }
</style>