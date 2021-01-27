@extends('layouts.app')

@section('styleCss')
.Qoption{
  cursor:pointer;
}
.GreenSelect
{
  background:green;
}
.RedSelect
{
  background:red;
}

@endsection

@section('content')

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
                    <button id="subBtn" type="submit" class="btn btn-primary form-control disabled">
                        {{ __('Scan Patient Barcode') }}
                    </button>
                  </div>
                </div>


            </form>

          </div>

        </div>
    </div>
</div>
@endsection

@section('scriptJs')
$(document).ready(function(){
  $(".Qoption").click(function(){
    var oResult = $(this).attr('rel');
    var oResultArr = oResult.split("_");
    var oNumber = oResultArr[1]
    var oValue = oResultArr[0]

    $("#q"+oNumber).val(oValue);
    if(oValue == "Yes")
    {
      $("#q"+oNumber+"Yes").addClass( "RedSelect" )
      $("#q"+oNumber+"No").removeClass( "GreenSelect" )
    }
    else if(oValue == "No")
    {
      $("#q"+oNumber+"Yes").removeClass( "RedSelect" )
      $("#q"+oNumber+"No").addClass( "GreenSelect" )
    }
    else
    {
      $("#q"+oNumber+"Yes").removeClass( "RedSelect" )
      $("#q"+oNumber+"No").removeClass( "GreenSelect" )
    }

    if($("#q1").val() == "No" && $("#q2").val() == "No" && $("#q3").val() == "No" && $("#q4").val() == "No")
    {
      $("#subBtn").removeClass( "disabled" )
      $("#have_insurance_no, #have_insurance_yes, #dosage_number_1, #dosage_number_2").removeAttr('disabled')
    }
    else
    {
      $("#subBtn").addClass( "disabled" )
      $("#have_insurance_no, #have_insurance_yes, #dosage_number_1, #dosage_number_2").attr('disabled', true)
    }
  });

  $("#insuranceSection").hide();

  $("#have_insurance_no").click(function(){
    $("#insuranceSection").hide();
    $("#administrator_name, #group_id, #coverage_effective_date, #primary_cardholder, #issuer_id, #insurance_type").removeAttr('required');
  });

  $("#have_insurance_yes").click(function(){
    $("#insuranceSection").show();
    $("#administrator_name, #group_id, #coverage_effective_date, #primary_cardholder, #issuer_id, #insurance_type").attr('required', true);
  });


});
@endsection
