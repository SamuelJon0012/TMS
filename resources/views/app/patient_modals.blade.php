@component('controls.modal',[
    'id'=>'patient-questionnaire-page-modal',
    'breadCrumbs'=>[
        ['caption'=>'home'],
    ]
])
    <div class="page-modal-inner">
        <div id="page-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 text-center">
                        <h3>{{ __('Patient Screening Questionnaire') }}</h3>
                    </div>
                    <div class="col-md-10">
                        <div class="card-body">
                            <form method="POST" action="/vsee/redirect">
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
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
                                            {{ __('Plan Type:') }}
                                        </div>
                                        <div class="col-8">
                                            <select id="plan_type" class="form-control @error('plan_type') is-invalid @enderror" name="plan_type" >
                                                <option value=""></option>
                                                <option value="0">{{ __('Medicare') }}</option>
                                                <option value="1">{{ __('Medicaid') }}</option>
                                                <option value="2">{{ __('Private Insurance') }}</option>
                                                <option value="3">{{ __('Self Pay') }}</option>
                                            </select>
                                            @error('insurance_type')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">
                                        <div class="col-4 text-right">
                                            {{ __('Plan ID:') }}
                                        </div>
                                        <div class="col-8">
                                            <input id="plan_id" type="text" class="form-control @error('plan_id') is-invalid @enderror" name="plan_id" value="{{ old('employer_name') }}"  autocomplete="employer_name"  placeholder="{{ __('') }}">
                                            @error('plan_id')
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
                                    <div class="form-group row justify-content-center">
                                        <div class="col-4 text-right">
                                            {{ __('Relationship to Primary Cardholder:') }}
                                        </div>
                                        <div class="col-8">
                                            <select id="relationship_to_primary_cardholder"
                                                    class="form-control @error('relationship_to_primary_cardholder') is-invalid @enderror"
                                                    name="relationship_to_primary_cardholder">
                                                <option value=""></option>
@if(env('BI_VERSION', '4.6') == '4.6')
                                                <option value="0">{{ __('I am the patient') }}</option>
                                                <option value="14">{{ __('Legal guardian of patient') }}</option>
                                                <option value="2">{{ __('Authorized representative of patient') }}</option>
@elseif(env('BI_VERSION') == '4.7')
                                                <option value="22">{{ __('I am the patient') }}</option>
                                                <option value="1">{{ __('Legal guardian of patient') }}</option>
                                                <option value="21">{{ __('Other') }}</option>
@endif
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
                                    <div class="col-md-6 text-center" id="yes-appointment"  title="{{ __('You must answer all 6 questions above') }}">
                                        <button id="subBtn" type="submit" class="btn btn-primary form-control disabled" title="{{ __('Click here to proceed') }}">
                                            {{ __('Schedule Appointment') }}
                                        </button>
                                    </div>
                                    {{--                                    <br/>--}}
                                    {{--
                                    <div class="col-md-6 text-center" id="no-appointment" style="display:none;">--}}
                                    {{--                                        <button id="subBtn" type="submit" class="btn btn-primary form-control">--}}
                                    {{--                                            {{ __('Save Information') }}--}}
                                    {{--                                        </button>--}}
                                    {{--                                        We are unable to schedule you vaccination a this time, however you can save your--}}
                                    {{--                                        insurance information and try back another time.--}}
                                    {{--
                                </div>
                                --}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sorry-page-modal modals">
        <div class="sorry-modal-inner">
            <div id="page-content">
                <div class="sorry-top">{{ __('THE SCREENING YOU COMPLETED INDICATES THAT YOU MAY BE AT INCREASED RISK FOR COVID-19') }}</div>
                <div class="sorry-feel">{{ __('IF YOU ARE NOT FEELING WELL, WE HOPE THAT YOU FEEL BETTER SOON') }}</div>
                <div class="sorry-main">
                    <div style="width: 100%;">
                        {{ __('Here are instructions for what to do next') }}
                    </div>
                    <div class="sorry-col-1" style="float:left;">
                        <div class="sorry-circle-1">1</div>
                        <div class="sorry-square-1">{{ __('If you are not already at home, please avoid contact with others and go straight home immediately') }}</div>
                    </div>
                    <div class="sorry-col-2" style="float:left;">
                        <div class="sorry-circle-2">2</div>
                        <div class="sorry-square-2">{{ __('Call your primary care provider for further instructions, including information about COVID-19 testing.') }}</div>
                    </div>
                    <div class="sorry-col-3" style="float:left;">
                        <div class="sorry-circle-3">3</div>
                        <div class="sorry-square-3">{{ __('Contact your supervisor (if you are an employee) or your contracting company (if you are a contractor) to discuss options for telework and/or leave.') }}</div>
                    </div>
                    <div style="clear:both"></div>
                    {{ __('At this time we cannot allow you to schedule a COVID-19 vaccination appointment.') }}
                    {{ __('When you can answer "No" to the first four questions, please come back and set up an appointment.') }}
                    {{ __(' Please click the button below to return to the home page') }}
                    <br/>
                    <br/>
                    <span class="btn btn-primary close-all" style="width: 300px;">Home Page</span>
                </div>
            </div>
        </div>
    </div>
@endcomponent


@component('controls.modal',[
    'id'=>'my-vaccine-page-modal',
    'breadCrumbs'=>[
        ['caption'=>'home'],
    ]
])
    <div class="page-modal-inner modals-inner">

        <div id="page-content">

            <h1>My Vaccines</h1>

            <div id="my-vaccine-info"></div>

        </div>

    </div>
@endcomponent

@component('controls.modal',[
    'id'=>'patient-help-modal',
    'breadCrumbs'=>[
        ['caption'=>'home'],
    ]
])
<h1 style="text-align:center;">TrackMy Lab Results Help</h1>

<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <main role="main" class="inner cover">
        <div id="viewer-div" rel="/files/default/help.html?601da043ace03">
            <h3>Welcome to TrackMy Lab Results a feature of TrackMy Solutions&#153</h3>
            <p>At TrackMy we are focused on the Double E, Double I of Healthcare - E²i² (Engage, Educate, Inform, Involve), thus anything we can do to assist you with your COVID testing, please do not hesitate to reach out.</p>


        </div>
    </main>
</div>
@endcomponent
