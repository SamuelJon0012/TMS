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
            The Health Insurance Portability and Accountability Act (HIPAA) provides safeguards to protect your privacy. Specifically, there are rules and restrictions on who may see or be notified of your Protected Health Information (PHI). These restrictions do not include the normal interchange of information  necessary  to  provide  you  with  standard  employee  benefits  and  services.  HIPAA provides  certain  rights  and  protections  to  you.  We  balance  these  needs  with  our  goal  of maintaining a safe workplace for all. Additional information is available from the U.S. Department of Health and Human Services. <a href='www.hhs.gov'>www.hhs.gov</a> 
        </p>
       
        <p>
            We have adopted the following policies:  
       </p>
       <div class='row'>
       		<div class='col-12'>
           		<ol type = "1" class="ml-3">
           			<li class="mb-3">
						Your testing information will be kept confidential except as necessary to maintain a safe workplace.            			</li>
           			<li class="mb-3">
						You agree to bring any concerns or complaints regarding privacy to the attention of HR.           			</li>
           			<li class="mb-3">
						Your access to your testing records will be in accordance with state and federal laws.
           			</li>
           			<li class="mb-3">
						You  have  the  right  to  request  restrictions  in  the  use  of  your  PHI.  However,  we  are  not obligated to alter firm policies to conform to your request.
       				</li>
           		</ol>
    
    			This specific HIPAA release form only applies to Covid-19 on-site testing data, which will only be accessible  to  authorized  personnel,
      			our  third  party  testing  vendor's  employees  who  have executed valid non-disclosure agreements, and as required by local/state or other government entities.
    		    The  retention  period  of  this  Covid-19  on-site  testing  information  will  end  at  the termination of the on-site testing program and will be purged from the HIPAA compliant systems.
 			</div>
		</div>


    </div>
    <div class="row mt-5 font-weight-bold">
    	<div class="col-12">
    		<div class='col-6'>
    			Name: <u>{{$name}}</u>
			</div>
    		<div class='col-6'>
    			Date: <u> {{date("Y-d-m")}} </u>
			</div>
	    	<div class="col-12">
				I, {{$name}} do hereby consent and acknowledge my agreement to the terms set forth in this HIPAA INFORMATION and CONSENT FORM and any subsequent changes in related policies.
			    I understand that this consent shall remain in force from this time forward.
    		</div>
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



