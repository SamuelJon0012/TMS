@extends('layouts.app')

@section('template_linked_css')
    @include('laravelusers::partials.styles')
@endsection

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
      border: 1px solid var(--blue);
  }

  .homeTop-button:hover {

      background-color: #ddeeff;

  }

  .button-image {
    height: 72px;
    max-height:50%;
  }

  .col-collapse{
    margin-top: 1pc;
  }

  .set-vaccine-location-wrapper{
    display: flex;
    align-items: center;
    border: 1px solid var(--blue);
    padding: 0;
  }

  .set-vaccine-location-wrapper button{
    width: 50%;
    border-radius: unset;
  }

  .set-vaccine-location-wrapper #currentSiteName{
    margin-left: 1pc;
  }

  @media(max-width: 32pc){
    .col-collapse{
      display: block;
      width: 90%;
      margin: 0.5pc auto;
    }
    .set-vaccine-location-wrapper{
      flex-direction: column;
    }
    .set-vaccine-location-wrapper button{
      width: 100%;
    }
    .set-vaccine-location-wrapper #currentSiteName{
      margin: 1pc;
      text-align: center;
    }
  }

@endsection

@section('content')

 

@component('controls.modal', [
    'id'=>'home-modal',
    'isHome'=>true,
    'breadCrumbs'=>[]
])
<div class="container">
    <div class="row justify-content-center">
        @if($v == '1')

            <div style="text-align:center; color:#f60;">There was a problem connecting to the appointment system.  Please try again later or contact support.

                <br>

                Info: {!! $m ?? '' !!}

            </div>

        @endif

        <div class="col-md-8">
          @if(session()->get('success'))
            <div class="alert alert-success">
              {{ session()->get('success') }}
            </div>
          @endif

          @if(Auth::check() && Auth::user()->hasRole('patient'))
            <?php
              $items = [
                [
                  'id'=>'lab-results-button',
                  'image'=>asset('images/lab-icon.png'),
                  'caption'=>__('My Lab Results'),
                  'hint'=>'This feature is currently unavailable',
                ],
/*                 [
                  'id'=>'myvaccine-button',
                  'image'=>asset('images/syringe.png'),
                  'caption'=>__('My Vaccines'),
                  'hint'=>'This feature is currently unavailable',
                ],
 */                [
                  'id'=>'',
                  'image'=>asset('images/alert-icon.png'),
                  'caption'=>__('Alerts'),
                  'hint'=>'This feature is currently unavailable',
                  'classnames'=>'alert-button',
                ],
                [
                  'id'=>'',
                  'image'=>asset('images/help-icon.png'),
                  'caption'=>__('Help'),
                  'onclick'=>"Modals.show('patient-help-modal')",
                ],
              ];
            ?>
            @include('controls.large_flow_buttons', ['items'=>$items])

            <!--<br/><br/>--><br/>
            <div class="row">

                @if($token != '0')

                    <div class="col-6 col-collapse">
                        <a target = "_blank" href="/vsee/return" class="btn btn-primary form-control">{{ __('Go to Appointments') }}</a>
                    </div>
<!--                     @if(env('APP_ENV') == 'development') {{-- TODO: remove before going live --}} -->
<!--                     <div class="col-6 col-collapse"> -->
<!--                        <button id="startCOVIDTest" class="btn btn-primary form-control" onclick="Modals.show('patient-COVID-test1-modal')">{{ __('Start COVID Test') }}</button>-->
<!--                     </div> -->
<!--                     @endif -->

                @endif

                <div class="col-6 col-collapse">
                    <button id="CovidTest" class="btn btn-primary form-control" onclick="window.location.href='/labResults/CovidTest'">{{ __('Start COVID Test') }}</button>
                </div>

            </div>
          @endif

          @if(Auth::check() && Auth::user()->hasRole('provider'))
            @include('controls.large_flow_buttons', ['items'=>[
              [
                'image'=>asset('images/magnifyingglass-icon.png'),
                'caption'=>__('Search For Patient'),
                'onclick'=>"Modals.show('patient-search-modal')",
              ],
              [
                'image'=>asset('images/friend-icon.png'),
                'caption'=>__('Scheduled Patients by Location'),
                'hint'=>'This feature is currently unavailable',
                'classnames'=>'provider-button',
              ],
              [
                'image'=>asset('images/settings-icon.png'),
                'caption'=>__('Settings'),
                'hint'=>'This feature is currently unavailable',
                'classnames'=>'settings-button',
              ],
              [
                'image'=>asset('images/help-icon.png'),
                'caption'=>__('Help'),
                'hint'=>'This feature is currently unavailable',
                'classnames'=>'help-button',
              ],

            ]])

            {{--<br><br><br>
                   <div class="barcode">
                           @php
                               $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                               echo $generator->getBarcode('038K20A_80777-273-10', $generator::TYPE_CODE_128);
                           @endphp
                           <div>
                               <span>{{ $bcCustomerId }}</span>
                               <span>-</span>
                               <span>{{ $bcSiteId }}</span>
                               <span>-</span>
                               <span>{{ $bcPatientId }}</span>
                           </div>
                    </div>--}}
            <br><br><br>
            <div class="row justify-content-center">
              <div>
              <div class="set-vaccine-location-wrapper" style="border: none">
                    @if(auth()->user()->hasRole('provider'))
                        <button style="margin-right: 10px" class="btn btn-primary" onclick="document.location='/scan-barcode'">{{ __('Scan Patient Barcode') }}</button>
                        <button style="margin-right: 10px" class="btn btn-primary" onclick="document.location='/set-vaccine-location'" disabled>{{ __('Set Vaccine Location') }}</button>
                    @else
                      <button id="setVaccineLocation" class="btn btn-primary" onclick="showVaccineLocationSearch()">{{ __('Set Location') }}</button>
                      <div id="currentSiteName"><?=($siteName)? $siteName : '<strong style="color:red">'.__('Not Selected').'</strong>'?></div>
                      <div class="col-6 col-collapse">
                        <button id="registerPatientByProvider" class="btn btn-primary form-control" onclick="document.location='/new-patient'">{{ __('Register a Patient') }}</button>
                      </div>
                    @endif
                </div>
              </div>


              <div class="col-6 col-collapse"  style='display:none'>
                <button id="registerPatientByProvider" class="btn btn-primary form-control" onclick="document.location='labResults/new-patient'">{{ __('Register a Patient') }}</button>
              </div>


            </div>
          @endif

          <br/><br/>
          <div class="row">
            <div class="col-12 text-center">
              <img src = "{{ asset('images/trackmysolutionslogoregtm-web.jpg') }}" style="max-width: 100%">
               <br/>
                [
                <a href="https://trackmyapp.us/files/default/terms.html" target="_blank">Terms</a>
                |
                <a href="https://trackmyapp.us/files/default/terms.html" target="_blank">Privacy policy</a>
                ]
            </div>
          </div>
        </div>
    </div>
</div>
@endcomponent

@endsection
