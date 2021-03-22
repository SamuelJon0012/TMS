@php
    $isProvider = $isProvider ?? false;
    $route = ($isProvider) ? 'register_new_parent' : 'register';
@endphp

@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 text-center">
          <h3 class=""><b>{{ __('HIPAA Information and Consent Form For') }}</b></h3>
          <h3 class="text-danger"><b>{{ __('COVID-19 Testing Only') }}</b></h3>
        </div>
        
    </div>
    <div class="row justify-content-center">
        <p class='mt-3'>
            The Health Insurance Portability and Accountability Act (HIPAA) provides safeguards to protect your privacy. Implementation of HIPAA requirements officially began on April 14, 2003. Many of the policies have been our practice for years. 
        </p>
        <p>
        	What this is all about: 
        </p>
        <p>
            Specifically, there are rules and restrictions on who may see or be notified of your Protected Health Information (PHI). These restrictions do not include the normal interchange of information necessary to provide you with office services. HIPAA provides certain rights and protections to you as the patient. We balance these needs with our goal of providing you with quality professional service and care. Additional information is available from the U.S. Department of Health and Human Services. <a href='www.hhs.gov'>www.hhs.gov</a> 
       </p>
       
        <p>
            We have adopted the following policies: 
       </p>
       <div class='row'>
       		<div class='col-12'>
           		<ol type = "1" class="ml-3">
           			<li class="mb-3">
           			   Patient information will be kept confidential except as is necessary to provide services or to ensure that all administrative matters related to your care are handled appropriately. 
           			</li>
           			<li class="mb-3">
           				You agree to bring any concerns or complaints regarding privacy to the attention of the office manager.
           			</li>
           			<li class="mb-3">
           				Your confidential information will not be used for the purposes of marketing or advertising of products, goods, or services.
           			</li>
           			<li class="mb-3">
           				We agree to provide patients with access to their records in accordance with state and federal laws.
       				</li>
           			<li class="mb-3">
           				You have the right to request restrictions in the use of your protected health information and to request change in certain policies used within the office concerning your PHI. However, we are not obligated to alter internal policies to conform to your request.
           			</li>
           		</ol>
    
                The sign-off of this specific HIPAA release form only applies to Covid-19 testing data. The Covid-19 testing data will only be viewed by person(s) who have signed valid non-disclosure agreements including the CLIA certified testing vendor, corporate medical and site personnel,
                and testing teams, and as required by local/state or other government entities. The retention period of this Covid-19 testing information will end at the termination of the testing engagement and will be purged from the HIPAA compliant systems using NIST compliant methods. 
			</div>
		</div>


    </div>
    <div class="row mt-5 font-weight-bold">
    	<div class="col-12">
    		Employee ID #: {{$id}}
    	</div>

    	<div class="col-12  mt-2">
    		Please Sign Below: 
    	</div>

    	<div class="col-12">
			I, <u>{{$name}}</u> date <u> {{date("Y-d-m")}} </u>do hereby consent and acknowledge my agreement to the terms set
			 forth in the HIPAA INFORMATION FORM and any subsequent changes in office policy. I understand that this consent shall remain
			 in force from this time forward
    	</div>
    </div>
     
     <form method='post' action='/labResults/saveCovid19'> 
     	@csrf
    	<div class='row'>    	
        	<div class="col-12  mt-5">
        		<input type='checkbox' name='agree' class='mr-2' required> Click here to acknowledge HIPAA Consent.
        		<input type='hidden' name='id' value="{{$id}}">
        	</div>
        	<div class="col-12  mt-3">
        		<input type='submit' class= "pl-4 pr-4 btn-primary" name='submit' value='Save'>
        	</div>
    	</div>
    </form>
    
</div>


@endsection



