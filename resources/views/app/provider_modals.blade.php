    <div class="search-modal modals">

        <div class="search-modal-inner">

            <div class="breadcrumbs"><span class="go_home"><- Home</span></div>

            <form name="search-form" onsubmit="return doPatientSearch('search-input');">

                <input id="search-input" value="jeff" type="search" class="form-control" name="search-input" placeholder="{{ __('Search by name, Email or phone number') }}" >

            </form>

            <div id="search-results"></div>

        </div>

    </div>
     <div class="provider-search-modal modals">

        <div class="provider-search-modal-inner">

            <-- USES THE SAME SEARCH CODE, PASS input_id TO /biq/find -->

            <div class="breadcrumbs"><span class="go_home"><- Home</span></div>

            <form name="provider-search-form" onsubmit="return doPatientSearch('provider-search-input');">

                <input id="provider-search-input" type="search" class="form-control" name="provider-search-input" placeholder="{{ __('Search by name, Email or phone number') }}" >

            </form>

            <div id="search-results"></div>

        </div>

    </div>
     <div class="set-vaccine-location-modal modals">

         <!-- SEARCH FOR SITES AND SET THE DEFAULT SITE(s?) FOR THE CURRENT USER -->

        <div class="set-vaccine-location-search-modal-inner">

            <div class="breadcrumbs"><span class="go_home"><- Home</span></div>

            <form name="vaccine-location-search-form" onsubmit="return doVaccineLocationSearch();">

                <input id="vaccine-location-search-input" type="search" class="form-control" name="vaccine-location-search-input" placeholder="{{ __('Search by Name, Address, City, Zip or County') }}" >

            </form>

            <div id="search-results"></div>

        </div>

    </div>
    <div class="patient-form-modal modals">

        <div class="patient-form-modal-inner">

            <div class="breadcrumbs"><span class="go_home go_link"><- Home</span> <span class="go_search go_link"> <- Search</span></div>

            <div id="patient-data">

                <div class="leftside">
                    <table class="patient-show">
                        <tr>
                            <td colspan="2" style="text-align:center;color:blue;">Personal Data</td>
                        </tr>
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
                            <th class="flabel">Address Line 1</th>
                            <td class="fvalue" id="address1"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Address Line 2</th>
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
                <div class="rightside">
                    <table class="patient-show">
                        <tr>
                            <td colspan="2" style="text-align:center;color:blue;">Demographic Data</td>
                        </tr>
                        <tr>
                            <th class="flabel">Email Address</th>
                            <td class="fvalue" id="email"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Mobile Phone Number</th>
                            <td class="fvalue" id="mphone"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Home Phone Number</th>
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
                        <tr>
                            <th class="flabel">Ethnicity</th>
                            <td class="fvalue" id="ethnicity"></td>
                        </tr>
                    </table>

                    <table class="patient-show">
                        <tr>
                            <td colspan="2" style="text-align:center;color:blue;">Vaccine Schedule</td>
                        </tr>
                        <tr>
                            <th class="flabel">Location</th>
                            <td class="fvalue" id="location"></td>
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
                </div>
            </div>
            <div style="clear:both;"></div>
            <form name="patient-form" onsubmit="return doProviderQuestionnaire();"><!----- CREATE THIS NEXT show & populate question modals --->
                <input type="hidden" value="0" id="patient_id" name="id"><!-- not really needed but fine -->
                <input type="submit" value="Confirm Patient" class="btn btn-primary">
            </form>
        </div>
    </div>
    <div class="provider-questionnaire-page-modal modals"><!-- template -->

        <div class="page-modal-inner">

            <div class="breadcrumbs"><span class="go_home"><- Home</span> <span class="go_search go_link"> <- Search</span> <span class="go_patient go_link"> <- Patient</span></div>

            <div id="page-content">


                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-12 text-center">
                            <h3>{{ __('Patient Screening Questionaire') }}</h3>
                        </div>

                        <div class="col-md-10">
                            <div class="card-body">

                                <form method="POST" action="" onsubmit="alert('Sub:');return false;">
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

                                    <br><br>
                                    <div class="row">
                                        <div class="col-8">
                                            <h5>{{ __('Please select the dose number that the patient is here for today?') }}</h5>
                                        </div>
                                        <div class="col-4">
                                            <input type="radio" name="dosage_number" id="dosage_number_1" value="1" checked disabled>
                                            <label for="dosage_number_1">{{ __('First Dose') }}</label>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="dosage_number" id="dosage_number_2" value="2" disabled>
                                            <label for="dosage_number_2">{{ __('Second Dose') }}</label>
                                        </div>
                                    </div>

                                    <br><br>
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <h5>{{ __('Do you have personal health insurance through your employer or private health insurance you have purchased on your own?') }}</h5>

                                            <input type="radio" name="have_insurance" id="have_insurance_yes" value="Yes" disabled>
                                            <label for="have_insurance_yes">{{ __('Yes') }}</label>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="have_insurance" id="have_insurance_no" value="No" checked disabled>
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

                                        <div class="form-group row justify-content-center">

                                            <div class="col-4 text-right">
                                                {{ __('Coverage Effective Date:') }}
                                            </div>
                                            <div class="col-8">
                                                <input id="coverage_effective_date" type="date" class="form-control @error('coverage_effective_date') is-invalid @enderror" name="coverage_effective_date" value="{{ old('coverage_effective_date') }}"  autocomplete="coverage_effective_date"  placeholder="{{ __('') }}" >

                                                @error('coverage_effective_date')
                                                <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                                                @enderror
                                            </div>
                                        </div>

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
                                                {{ __('Relationship to Patient:') }}
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

                                    <div class="form-group row justify-content-center">
                                        <div class="col-md-6 text-center">
                                            <button id="subBtn" type="submit" onclick="return doScanner()" class="btn btn-primary form-control disabled">
                                                {{ __('Scan Patient Barcode') }}
                                            </button>
                                        </div>
                                    </div>


                                </form>

                            </div>

                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
    <div class="scanner-page-modal modals">

        <div class="page-modal-inner">

            <div class="breadcrumbs"><span class="go_home"><- Home</span> <span class="go_search go_link"> <- Search</span> <span class="go_patient go_link"> <- Patient</span> <span class="go_questionnaire go_link"> <- Questionnaire</span></div>

            <div id="page-content"></div>

        </div>
    </div>