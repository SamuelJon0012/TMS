@component('controls.modal',[
    'id'=>'patient-search-modal',
    'breadCrumbs'=>[
        ['caption'=>'home'],
    ]
])
    <div class="search-modal-inner">

        <div id="page-content">

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 text-center">
                        <h3>{{ __('Enter the Patient\'s Information to Search') }}</h3>
                    </div>

                    <div class="col-md-10">
                        <div class="card-body">

                            <form name="search-form" onsubmit="doPatientSearch('search-input'); return false;">

                                <input id="search-input" type="search" class="form-control" name="search-input" placeholder="{{ __('Search by Last Name, Email or Phone Number') }}" >

                            </form>

                            <div id="search-results"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endcomponent

     <div class="provider-search-modal modals">

        <div class="provider-search-modal-inner">

            <-- USES THE SAME SEARCH CODE, PASS input_id TO /biq/find -->

            <div id="page-content">

                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-12 text-center">
                            <h3>{{ __('Scheduled Patients by Location') }}</h3>
                        </div>

                        <div class="col-md-10">
                            <div class="card-body">


                            <div class="breadcrumbs"><span class="go_home"><- Home</span></div>

                            <form name="provider-search-form" onsubmit="doPatientSearch('provider-search-input'); return false;">

                                <input id="provider-search-input" type="search" class="form-control" name="provider-search-input" placeholder="{{ __('Search by Last Name, Email or phone number') }}" >

                            </form>

                            <div id="search-results"></div>

                        </div>

                    </div>
                    </div>
                </div>
            </div>
        </div>
     </div>


@component('controls.modal',[
    'id'=>'set-vaccine-location-modal',
    'breadCrumbs'=>[
        ['caption'=>'home'],
    ]
])
    <!-- SEARCH FOR SITES AND SET THE DEFAULT SITE(s?) FOR THE CURRENT USER -->

    <div class="set-vaccine-location-search-modal-inner">

        <div id="page-content">

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 text-center">
                        <h3>{{ __('Select Location') }}</h3>
                    </div>

                    <div class="col-md-10">
                        <div class="card-body">

                            <form name="vaccineLocationSearchForm" onsubmit="doVaccineLocationSearch(); return false">

                                <input id="vaccine-location-search-input" type="search" class="form-control" name="searchInput" placeholder="{{ __('Search by Name, Address, City, Zip or County') }}" >

                            </form>

                            <div id="vaccine-location-search-results"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endcomponent


@component('controls.modal',[
    'id'=>'patient-form-modal',
    'breadCrumbs'=>[
        ['caption'=>'home'],
        ['caption'=>'Search', 'className'=>'go_search'],
    ]
])
    <div class="patient-form-modal-inner">

        <div id="page-content">

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 text-center">
                        <h3>{{ __('Patient Confirmation') }}</h3>
                    </div>

                    <div class="col-md-10">
                        <div class="card-body">
<br/>
<br/>
<br/>
                            <div id="patient-data">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="form-reg-header">
                                                {{ __('Personal Data') }}
                                            </div>
                                            <div class="card-body text-center">
                                                <br>
                                                {{ __('Please confirm the identity of your visitor and the information on this page, then proceed to the next step.') }}
                                                <br>
                                                <table class="patient-show"><!-- mebe -->
                                                    <tr>
                                                        <th class="flabel">First Name</th>
                                                        <td class="fvalue" id="first_name"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">Last Name</th>
                                                        <td class="fvalue" id="last_name"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">Date of Birth</th>
                                                        <td class="fvalue" id="date_of_birth"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">SSN</th>
                                                        <td class="fvalue" id="ssn"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">Driver's License</th>
                                                        <td class="fvalue" id="dl_number"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">Address</th>
                                                        <td class="fvalue" id="address1"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">Apt / Unit</th>
                                                        <td class="fvalue" id="address2"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">City</th>
                                                        <td class="fvalue" id="city"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">State</th>
                                                        <td class="fvalue" id="state"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">Zipcode</th>
                                                        <td class="fvalue" id="zipcode"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <br/>
                                        <br/>
                                        <form name="patient-form" onsubmit="return doProviderQuestionnaire();"><!----- CREATE THIS NEXT show & populate question modals --->
                                            <input type="hidden" value="0" id="patient_id" name="id"><!-- not really needed but fine -->
                                            <input type="submit" value="Confirm Patient" class="btn btn-primary">
                                        </form>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="form-reg-header">
                                                {{ __('Demographics') }}
                                            </div>
                                            <div class="card-body text-center">
{{--                                                    <br>--}}
{{--                                                    {{ __('Please confirm....') }}--}}
{{--                                                    <br><br>--}}

                                                <table class="patient-show">
                                                    <tr>
                                                        <th class="flabel">Email</th>
                                                        <td class="fvalue" id="email"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">Mobile Phone</th>
                                                        <td class="fvalue" id="mphone"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">Home Phone</th>
                                                        <td class="fvalue" id="hphone"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">Birth Sex</th>
                                                        <td class="fvalue" id="birth_sex"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">Race</th>
                                                        <td class="fvalue" id="race"></td>
                                                    </tr>
<!-- Todo: Ethnicity is wrong in registration form, will need to convert in spooler -->
                                                    {{--                                                        <tr>--}}
{{--                                                            <th class="flabel">Ethnicity</th>--}}
{{--                                                            <td class="fvalue" id="ethnicity"></td>--}}
{{--                                                        </tr>--}}
                                                </table>

                                                <table class="patient-show">
                                                    <tr>
                                                        <td colspan="2" style="text-align:center;color:blue;">
                                                            Vaccine Schedule
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">Location</th>
                                                        <td class="fvalue" id="location">location</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">Date</th>
                                                        <td class="fvalue" id="date"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">Time</th>
                                                        <td class="fvalue" id="time"></td>
                                                    </tr>
                                                </table>
                                                <table class="patient-show" id="schedule2">
                                                    <tr>
                                                        <td colspan="2" style="text-align:center;color:blue;">
                                                            Vaccine Schedule #2
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">Location</th>
                                                        <td class="fvalue" id="location2">location2</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">Date</th>
                                                        <td class="fvalue" id="date2"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">Time</th>
                                                        <td class="fvalue" id="time2"></td>
                                                    </tr>
                                                </table>
                                                <table class="patient-show" id="schedule3">
                                                    <tr>
                                                        <td colspan="2" style="text-align:center;color:blue;">
                                                            Vaccine Schedule #3
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">Location</th>
                                                        <td class="fvalue" id="location3">location3</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">Date</th>
                                                        <td class="fvalue" id="date3"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">Time</th>
                                                        <td class="fvalue" id="time3"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">Total</th>
                                                        <td class="fvalue" id="total_count"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="flabel">More</th>
                                                        <td class="fvalue" id="more"></td>
                                                    </tr>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endcomponent


@component('controls.modal',[
    'id'=>'provider-questionnaire-page-modal',
    'breadCrumbs'=>[
        ['caption'=>'home'],
        ['caption'=>'Search', 'className'=>'go_search'],
        ['caption'=>'Patient', 'className'=>'go_patient'],
    ]
])
    <div class="page-modal-inner">

        <div id="page-content">

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 text-center">
                        <h3>{{ __('Patient Screening Questionaire') }}</h3>
                    </div>

                    <div class="col-md-10">
                        <div class="card-body">
                            <form method="POST" action="/vsee/saveonly">
                                @csrf
                                <div class="row">
                                    <div class="col-8">
                                        <h5>{{ __('Please read each question carefully') }} </h5>
                                    </div>
                                    <div class="col-4">
                                        <h5>{{ __('Please click on the answer that applies to you') }} </h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-8 border border-dark">
                                        {{ __('Have you experienced any of the following symptoms in the past 48 hours:') }}
                                        <ul>
                                            <li>{{ __('fever or chills') }} </li>
                                            <li>{{ __('cough') }} </li>
                                            <li>{{ __('shortness of breath or difficulty breathing') }} </li>
                                            <li>{{ __('fatigue') }} </li>
                                            <li>{{ __('muscle or body aches') }} </li>
                                            <li>{{ __('headache') }} </li>
                                            <li>{{ __('new loss of taste or smell') }} </li>
                                            <li>{{ __('sore throat') }} </li>
                                            <li>{{ __('congestion or runny nose') }} </li>
                                            <li>{{ __('nausea or vomiting') }} </li>
                                            <li>{{ __('diarrhea') }} </li>
                                        </ul>
                                    </div>
                                    <div id="q1Yes" class="Qoption col-2 border-dark border-top border-bottom text-center" rel="Yes_1">
                                        <br><br><br><br><br><br>
                                        {{ __('YES') }}
                                    </div>
                                    <div id="q1No" class="Qoption col-2 border border-dark text-center" rel="No_1">
                                        <br><br><br><br><br><br>
                                        {{ __('NO') }}
                                    </div>
                                    <input type="hidden" name="q1" id="q1" value="">
                                </div>

                                <div class="row">
                                    <div class="col-8 border border-top-0 border-dark">
                                        {{ __('Within the past 14 days, have you been in close physical contact (6 feet or closer for a cumulative total of 15 minutes) with:') }}
                                        <ul>
                                            <li>{{ __('Anyone who is known to have laboratory-confirmed COVID-19?') }} <br> {{ __('OR')}} </li>
                                            <li>{{ __('Anyone who has any symptons consistent with COVID-19?') }} </li>
                                        </ul>
                                    </div>
                                    <div id="q2Yes" class="Qoption col-2  border-dark  border-bottom text-center" rel="Yes_2">
                                        <br><br>
                                        {{ __('YES') }}
                                    </div>
                                    <div id="q2No" class="Qoption col-2 border border-top-0 border-dark text-center" rel="No_2">
                                        <br><br>
                                        {{ __('NO') }}
                                    </div>
                                    <input type="hidden" name="q2" id="q2" value="">
                                </div>

                                <div class="row">
                                    <div class="col-8 border border-top-0 border-dark">
                                        {{ __('Are you isolating or quarantining because you may have been exposed to a person with COVID-19 or are worried that you may be sick with COVID-19?') }}
                                    </div>
                                    <div id="q3Yes" class="Qoption col-2  border-dark  border-bottom text-center" rel="Yes_3">
                                        <br>
                                        {{ __('YES') }}
                                        <br><br>
                                    </div>
                                    <div id="q3No" class="Qoption col-2 border border-top-0 border-dark text-center" rel="No_3">
                                        <br>
                                        {{ __('NO') }}
                                        <br><br>
                                    </div>
                                    <input type="hidden" name="q3" id="q3" value="">
                                </div>

                                <div class="row">
                                    <div class="col-8 border border-top-0 border-dark">
                                        {{ __('Are you currently waiting on the result of a COVID-19 test?') }}
                                    </div>
                                    <div id="q4Yes" class="Qoption col-2  border-dark  border-bottom text-center" rel="Yes_4">
                                        <br>
                                        {{ __('YES') }}
                                        <br><br>
                                    </div>
                                    <div id="q4No" class="Qoption col-2 border border-top-0 border-dark text-center" rel="No_4">
                                        <br>
                                        {{ __('NO') }}
                                        <br><br>
                                    </div>
                                    <input type="hidden" name="q4" id="q4" value="">
                                </div>
                                <div class="row">
                                    <div class="col-8 border border-top-0 border-dark">
                                        {{ __('Have you been previously diagnosed with COVID-19?') }}
                                    </div>
                                    <div id="q5Yes" class="Qoption col-2  border-dark  border-bottom text-center" rel="Yes_5">
                                        <br>
                                        {{ __('YES') }}
                                        <br><br>
                                    </div>
                                    <div id="q5No" class="Qoption col-2 border border-top-0 border-dark text-center" rel="No_5">
                                        <br>
                                        {{ __('NO') }}
                                        <br><br>
                                    </div>
                                    <input type="hidden" name="q5" id="q5" value="">
                                </div>
                                <div class="row">
                                    <div class="col-8 border border-top-0 border-dark">
                                        {{ __('Do you have a vaccine allergy?') }}
                                    </div>
                                    <div id="q6Yes" class="Qoption col-2  border-dark  border-bottom text-center" rel="Yes_6">
                                        <br>
                                        {{ __('YES') }}
                                        <br><br>
                                    </div>
                                    <div id="q6No" class="Qoption col-2 border border-top-0 border-dark text-center" rel="No_6">
                                        <br>
                                        {{ __('NO') }}
                                        <br><br>
                                    </div>
                                    <input type="hidden" name="q6" id="q6" value="">
                                </div>
                                <br><br>
                                <div class="row">
                                    <div class="col-8">
                                        <h5>{{ __('Please select the dose number that the patient is here for today?') }}</h5>
                                    </div>
                                    <div class="col-4">
                                        <input type="radio" name="dosage_number" id="dosage_number_1" value="1" checked>
                                        <label for="dosage_number_1">{{ __('First Dose') }}</label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="dosage_number" id="dosage_number_2" value="2">
                                        <label for="dosage_number_2">{{ __('Second Dose') }}</label>
                                    </div>
                                </div>

                                <br><br>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <h5>{{ __('Do you have personal health insurance through your employer or private health insurance you have purchased on your own?') }}</h5>

                                        <input type="radio" name="have_insurance" id="have_insurance_yes" value="Yes">
                                        <label for="have_insurance_yes">{{ __('Yes') }}</label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="have_insurance" id="have_insurance_no" value="No" checked>
                                        <label for="have_insurance_no">{{ __('No') }}</label>
                                    </div>
                                </div>

                                <br><br>
                                <div class="row" id="insuranceSection" style="display:none;">
                                    <div class="form-group row justify-content-center">
                                        <div class="col-12">
                                            <h5>{{ __('Please provide the necessary insurance information') }}</h5>
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">
                                        <div class="col-4 text-right">
                                            {{ __('Insurance Company Name:') }}
                                        </div>
                                        <div class="col-8">
                                            <input id="administrator_name" type="text" class="form-control @error('administrator_name') is-invalid @enderror" name="administrator_name" value="{{ old('administrator_name') }}"  autocomplete="administrator_name"  placeholder="{{ __('') }}" >

                                            @error('administrator_name')
                                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">

                                        <div class="col-4 text-right">
                                            {{ __('Employer Name:') }}
                                        </div>
                                        <div class="col-8">
                                            <input id="employer_name" type="text" class="form-control @error('employer_name') is-invalid @enderror" name="employer_name" value="{{ old('employer_name') }}"  autocomplete="employer_name"  placeholder="{{ __('') }}">

                                            @error('employer_name')
                                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">

                                        <div class="col-4 text-right">
                                            {{ __('Group id/Number:') }}
                                        </div>
                                        <div class="col-8">
                                            <input id="group_id" type="text" class="form-control @error('group_id') is-invalid @enderror" name="group_id" value="{{ old('group_id') }}"  autocomplete="group_id"  placeholder="{{ __('') }}" >

                                            @error('group_id')
                                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                            @enderror
                                        </div>
                                    </div>

{{--                                        <div class="form-group row justify-content-center">--}}

{{--                                            <div class="col-4 text-right">--}}
{{--                                                {{ __('Coverage Effective Date:') }}--}}
{{--                                            </div>--}}
{{--                                            <div class="col-8">--}}
{{--                                                <input id="coverage_effective_date" type="date" class="form-control @error('coverage_effective_date') is-invalid @enderror" name="coverage_effective_date" value="{{ old('coverage_effective_date') }}"  autocomplete="coverage_effective_date"  placeholder="{{ __('') }}" >--}}

{{--                                                @error('coverage_effective_date')--}}
{{--                                                <span class="invalid-feedback" role="alert">--}}
{{--                              <strong>{{ $message }}</strong>--}}
{{--                          </span>--}}
{{--                                                @enderror--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

                                    <div class="form-group row justify-content-center">

                                        <div class="col-4 text-right">
                                            {{ __('Primary Insured Name:') }}
                                        </div>
                                        <div class="col-8">
                                            <input id="primary_cardholder" type="text" class="form-control @error('primary_cardholder') is-invalid @enderror" name="primary_cardholder" value="{{ old('primary_cardholder') }}"  autocomplete="primary_cardholder"  placeholder="{{ __('') }}" >

                                            @error('primary_cardholder')
                                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">

                                        <div class="col-4 text-right">
                                            {{ __('Primary Insured ID:') }}
                                        </div>
                                        <div class="col-8">
                                            <input id="issuer_id" type="text" class="form-control @error('issuer_id') is-invalid @enderror" name="issuer_id" value="{{ old('issuer_id') }}"  autocomplete="issuer_id"  placeholder="{{ __('') }}" >

                                            @error('issuer_id')
                                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">

                                        <div class="col-4 text-right">
                                            {{ __('Insurance Type:') }}
                                        </div>
                                        <div class="col-8">
                                            <select id="insurance_type" class="form-control @error('insurance_type') is-invalid @enderror" name="insurance_type" >
                                                <option value=""></option>
                                                <option value="0">{{ __('SelfPay') }}</option>
                                                <option value="1">{{ __('Primary') }}</option>
                                                <option value="2">{{ __('Secondary') }}</option>
                                            </select>

                                            @error('insurance_type')
                                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <input type="hidden" name="provider_id" id="provider_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="q_patient_id" id="q_patient_id" value="">
                                <div class="form-group row justify-content-center">
                                    <div class="col-md-4 text-center">
                                        <button id="save-btn" type="submit" class="btn btn-primary form-control ">
                                            {{ __('Save') }}
                                        </button>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <span id="scan-btn" type="submit" onclick="return doScanner()" class="btn btn-primary form-control ">
                                            {{ __('Scan') }}
                                        </span>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <span id="back-btn" type="submit" onclick="$('.go_patient').click()" class="btn btn-primary form-control ">
                                            {{ __('Back') }}
                                        </span>
                                    </div>



                                    </div>
                                </div>


                            </form>

                        </div>

                    </div>
                </div>
            </div>


        </div>

    </div>
@endcomponent



@component('controls.modal',[
    'id'=>'scanner-page-modal',
    'breadCrumbs'=>[
        ['caption'=>'home'],
        ['caption'=>'Search', 'className'=>'go_search'],
        ['caption'=>'Patient', 'className'=>'go_patient'],
        ['caption'=>'Questionnaire', 'className'=>'go_questionnaire'],
    ]
])
    <div class="page-modal-inner">

        <div id="page-content">

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 text-center">
                        <h3>{{ __('Scan Barcode into this form') }}</h3>
                    </div>

                    <div class="col-md-10">

                        <div class="card-body">

<div id="barcode-form">
                            <input id="barcode-input" value="" type="text" class="form-control" name="search-input" placeholder="{{ __('Scan Barcode Here') }}" >

                            <br/>

                            <b>Administration Site</b>
                            <br/>
                            <select id='admin-site' name='admin-site'>
                                <option value="0">RA-Right Arm</option>
                                <option value="1">BU-Buttock</option>
                                <option value="2">LA-Left Arm</option>
                                <option value="3">RT-Right Thigh</option>
                                <option value="4">LT-Left Thigh</option>
                                <option value="5">LUA-Left Upper Arm</option>
                                <option value="6">RUA-Right Upper Arm</option>
                            </select>
                            <br/><br/>

                            <button onclick="doHandleBarcode()" class='btn btn-primary save-barcode-form'>Save Administration Site</button>

                            </div>
                            <div id="barcode-results"></div>
                            <div id="barcode-go-home" style="display:none;">
                                <span class="go_search btn btn-primary">Back to Search Form</span>
                                <br/>
                                <span class="btn btn-link"

                                        onclick="$('#barcode-go-home').hide(); $('#barcode-form').show();$('#barcode-input').val('').focus();">Scan Again</span>

                            </div>
                            <br/>
                            <br/>
                            <div style='display:none' id="barcode-allergy">Patient Has a Prior Allergy - Ask to stay 30 minutes in observation area</div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endcomponent
