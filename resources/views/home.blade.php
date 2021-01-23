@extends('layouts.app')

@section('styleCss')

.homeTop-button {
      text-align: center;
      font-size:120%;
      margin: 13px;
      padding:32px 22px 22px 22px;
      width: 174px;
      height:174px;
      cursor:pointer;
      border-radius: 12px;
      border: 1px solid #007dc3;
  }

  .homeTop-button:hover {

      background-color: #ddeeff;

  }

.button-image {
    height: 72px;
  }

@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          @if(session()->get('success'))
            <div class="alert alert-success">
              {{ session()->get('success') }}
            </div>
          @endif

          @if(Auth::check() && Auth::user()->hasRole('patient'))
            <div class="row">
              <div class="col-3">
                <div id="myvaccine-button" class="homeTop-button">
                  <img class="button-image" src="https://djdev.trackmyapp.us/images/syringe.png">
                  <br>
                  My Vaccines
                </div>
              </div>

              <div class="col-3">
                <div class="alert-button homeTop-button">
                  <img class="button-image" src="https://djdev.trackmyapp.us/images/alert-icon.png" />
                  <br/>
                  Alerts
                </div>
              </div>

              <div class="col-3">
                <div class="settings-button homeTop-button">
                  <img class="button-image" src="https://djdev.trackmyapp.us/images/settings-icon.png" />
                  <br/>
                  Settings
                </div>
              </div>

              <div class="col-3">
                <div class="help-button homeTop-button">
                  <img class="button-image" src="https://djdev.trackmyapp.us/images/help-icon.png" />
                  <br/>
                  Help
                </div>
              </div>

            </div>
            <br><br><br>
            <div class="row">
              <div class="col-6">
                <button class="btn btn-primary form-control">Schedule a Vaccine Visit</button>
              </div>
              <div class="col-6">
                <button class="btn btn-primary form-control" id="addVaccine">Add a Vaccine</button>
              </div>
            </div>
          @endif

          @if(Auth::check() && Auth::user()->hasRole('provider'))
            <div class="row">
              <div class="col-3">
                <div class="patient-button homeTop-button">
                  <img class="button-image" src="https://djdev.trackmyapp.us/images/magnifyingglass-icon.png">
                  <br>
                  Search For Patient
                </div>
              </div>

              <div class="col-3">
                <div class="provider-button homeTop-button">
                  <img class="button-image" src="https://djdev.trackmyapp.us/images/friend-icon.png" />
                  <br/>
                  Provider Reports
                </div>
              </div>

              <div class="col-3">
                <div class="settings-button homeTop-button">
                  <img class="button-image" src="https://djdev.trackmyapp.us/images/settings-icon.png" />
                  <br/>
                  Settings
                </div>
              </div>

              <div class="col-3">
                <div class="help-button homeTop-button">
                  <img class="button-image" src="https://djdev.trackmyapp.us/images/help-icon.png" />
                  <br/>
                  Help
                </div>
              </div>

            </div>

          @endif

          <br><br><br>
          <div class="row">
            <div class="col-12 text-center">
              <img src = "https://djdev.trackmyapp.us/images/trackmysolutionslogoregtm-web.jpg">
            </div>
          </div>



            <!-- <div class="card">
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
            </div> -->
        </div>
    </div>
</div>

@endsection

@section('scriptJs')

$(document).ready(function(){
  $("#addVaccine").click(function(){
    window.location.href = 'patientvaccine/create';
  });
});

@endsection
