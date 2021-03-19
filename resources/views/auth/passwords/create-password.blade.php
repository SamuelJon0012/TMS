@extends('layouts.app')

@section('content')
    <div style="max-width: 500px; margin: 0 auto">
        <h4>Profile Activation</h4>
        <form class="pt-3" action="{{ url()->current() }}" method="post">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-group">
                    <div class="input-group-prepend bg-transparent"></div>
                    <input name="email" type="text" class="form-control form-control-lg border-radius" id="email" value="{{ $user['email'] }}" disabled>
                </div>
            </div>
            <div class="form-group">
                <label for="password">New Password</label>
                <div class="input-group">
                    <div class="input-group-prepend bg-transparent"></div>
                    <input type="password" name="password" class="form-control form-control-lg border-radius" id="password" placeholder="Password">
                </div>
                @error('password')
                    <small class="text-danger font-weight-bold">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Confirm Password</label>
                <div class="input-group">
                    <div class="input-group-prepend bg-transparent"></div>
                    <input type="password" name="password_confirmation" class="form-control form-control-lg border-radius" id="password" placeholder="Confirm Password">
                </div>
            </div>
            <div class="my-3">
                <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                    Activate My Account
                </button>
            </div>
        </form>
    </div>
@endsection

@section("styleCss")
    .border-radius {
        border-top-left-radius: .3rem!important;
        border-bottom-left-radius: .3rem!important;
    }
@endsection
