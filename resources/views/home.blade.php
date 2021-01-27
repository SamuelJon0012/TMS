@extends('layouts.app')

@section('styleCss')

.homeTop-button {
      text-align: center;
      font-size:100%;
      margin: 0px;
      padding:32px 22px 22px 22px;
      width: 100%;
      height: 200px;
      cursor:pointer;
      border-radius: 12px;
      border: 1px solid #007dc3;
  }

  .homeTop-button:hover {

      background-color: #ddeeff;

  }

.button-image {
    height: 72px;
    max-height:50%;
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
                  {{ __('My Vaccines') }}
                </div>
              </div>

              <div class="col-3">
                <div class="alert-button homeTop-button">
                  <img class="button-image" src="https://djdev.trackmyapp.us/images/alert-icon.png" />
                  <br/>
                  {{ __('Alerts') }}
                </div>
              </div>

              <div class="col-3">
                <div class="settings-button homeTop-button">
                  <img class="button-image" src="https://djdev.trackmyapp.us/images/settings-icon.png" />
                  <br/>
                  {{ __('Settings') }}
                </div>
              </div>

              <div class="col-3">
                <div class="help-button homeTop-button">
                  <img class="button-image" src="https://djdev.trackmyapp.us/images/help-icon.png" />
                  <br/>
                  {{ __('Help') }}
                </div>
              </div>

            </div>
            <br/><br/><br/>
            <div class="row">
              <div class="col-6">
                <button id="scheduleVaccineAppointment" class="btn btn-success form-control">{{ __('Schedule a Vaccine Appointment') }}</button>
              </div>
              <div class="col-6">
                <button id="addVaccine" class="btn btn-success form-control" id="addVaccine">{{ __('Add a Vaccine') }}</button>
              </div>
            </div>
          @endif

          @if(Auth::check() && Auth::user()->hasRole('provider'))
            <div class="row">
              <div class="col-3">
                <div class="patient-button homeTop-button">
                  <img class="button-image" src="https://djdev.trackmyapp.us/images/magnifyingglass-icon.png">
                  <br>
                  {{ __('Search For Patient') }}
                </div>
              </div>

              <div class="col-3">
                <div class="provider-button homeTop-button">
                  <img class="button-image" src="https://djdev.trackmyapp.us/images/friend-icon.png" />
                  <br/>
                  {{ __('Scheduled Patients by Location') }}
                </div>
              </div>

              <div class="col-3">
                <div class="settings-button homeTop-button">
                  <img class="button-image" src="https://djdev.trackmyapp.us/images/settings-icon.png" />
                  <br/>
                  {{ __('Settings') }}
                </div>
              </div>

              <div class="col-3">
                <div class="help-button homeTop-button">
                  <img class="button-image" src="https://djdev.trackmyapp.us/images/help-icon.png" />
                  <br/>
                  {{ __('Help') }}
                </div>
              </div>
            </div>
            <br><br><br>
            <div class="row justify-content-center">
              <div class="col-6">
                <button id="setVaccineLocation" class="btn btn-success form-control set-vaccine-location">{{ __('Set Vaccine Location') }}</button>
              </div>
            </div>
          @endif

          <br/><br/>
          <div class="row">
            <div class="col-12 text-center">
              <img src = "https://djdev.trackmyapp.us/images/trackmysolutionslogoregtm-web.jpg">
            </div>
          </div>
        </div>
    </div>
</div>

@endsection

@section('scriptJs')

$(document).ready(function(){
  $("#addVaccine").click(function(){
    window.location.href = 'patientvaccine/create';
  });

  $("#setVaccineLocation").click(function(){
    window.location.href = '';
  });

});

@endsection
