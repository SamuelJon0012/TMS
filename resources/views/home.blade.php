@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                  @if(Auth::check() && Auth::user()->hasRole('patient'))
                    {{ __('Patient') }}
                  @endif

                  @if(Auth::check() && Auth::user()->hasRole('provider'))
                    {{ __('Provider') }}
                  @endif

                  @if(Auth::check() && Auth::user()->hasRole('admin'))
                    {{ __('Admin') }}
                  @endif

                  {{ __('Dashboard') }}
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in ! ') }}

                    <br><br>
                    <b>
                      @if(Auth::check() && Auth::user()->hasRole('patient'))
                        {{ __('PATIENT') }}
                      @endif

                      @if(Auth::check() && Auth::user()->hasRole('provider'))
                        {{ __('PROVIDER') }}
                      @endif
                      Menus will be coming here.
                    </b>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
