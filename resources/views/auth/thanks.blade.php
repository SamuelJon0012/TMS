@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                <!-- <div class="card-header">{{ __('Reset Password') }}</div> -->

                    <div class="card-body text-center">


                        <h1>Thank you</h1>


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

</div>

@endsection
