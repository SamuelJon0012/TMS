<div class="my-vaccine-page-modal modals">

    <div class="page-modal-inner modals-inner">

        <div class="breadcrumbs"><span class="go_home"><- Home</span></div>

        <div id="page-content">

            <h1>My Vaccines</h1>

            <div id="my-vaccine-info"></div>

        </div>


    </div>
</div>
<div class="adverse-event-form-page-modal modals">

    <div class="page-modal-inner modals-inner">

        <div class="breadcrumbs"><span class="go_home"><- Home</span></div>

        <div id="page-content"></div>

    </div>
</div>
<div class="alerts-page-modal modals">

    <div class="page-modal-inner modals-inner">

        <div class="breadcrumbs"><span class="go_home"><- Home</span></div>

        <div id="page-content"></div>

    </div>
</div>
<div class="patient-settings-page-modal modals">

    <div class="page-modal-inner modals-inner">

        <div class="breadcrumbs"><span class="go_home"><- Home</span></div>

        <div id="page-content"></div>

    </div>
</div>
<div class="provider-settings-page-modal modals">

    <div class="page-modal-inner modals-inner">

        <div class="breadcrumbs"><span class="go_home"><- Home</span></div>

        <div id="page-content"></div>

    </div>
</div>
<div class="cover-page-modal modals">

    <div class="page-modal-inner modals-inner">

        <div id="page-content">

            <!-- Eventually make this the CDN/Bucket Cover Page -->

            <h1>Affirmation Statement</h1>
            <div>
                I affirm that I meet one of the 1A criteria listed below
            </div>

            <div>
                <ul>
                    <li>Health care personnel including, but not limited to:</li>
                    <ul>
                        <li>Emergency medical service personnel</li>
                        <li>Nurses</li>
                        <li>Physicians</li>
                        <li>Dentists</li>
                        <li>Dental hygienists</li>
                        <li>Chiropractors</li>
                        <li>Therapists</li>
                        <li>Phlebotomists</li>
                        <li>Pharmacists</li>
                        <li>Technicians</li>
                        <li>Pharmacy technicians</li>
                        <li>Health professions students and trainees</li>
                        <li>Direct support professionals</li>
                        <li>Clinical personnel in school settings or correctional facilities</li>
                        <li>Contractual HCP not directly employed by the health care facility</li>
                        <li>Persons not directly involved in patient care but potentially exposed to infectious material that can transmit disease among or from health care personnel and patients</li>
                        <li>Persons ages 65 and older</li>
                        <li>Persons ages 16-64 with high risk conditions</li>
                    </ul>
                    <li>Cancer</li>
                    <li>COPD</li>
                    <li>Down Syndrome</li>
                    <li>Heart conditions, such as heart failure, coronary artery disease, or cardiomyopathies</li>
                    <li>Immunocompromised state (weakened immune system) from solid organ transplant or from blood or bone marrow transplant, immune deficiencies , HIV, use of corticosteroids, or use of other immune weakening medicines</li>
                    <li>Obesity (BMI of 30 kg/m2 or higher but &#62 40 kg/m2)</li>
                    <li>Severe obesity (BMI &#8805 40 kg/m2)</li>
                    <li>Pregnancy</li>
                    <li>Sickle cell disease</li>
                    <li>Smoking</li>
                    <li>Type 2 diabetes mellitus</li>
                </ul>
            </div>

            <br>

            <div style="text-align:center; width: 100%;">
                <center>
                    <B>{!! $message ?? '' !!}</B><br/>
                 <form id='affirm-form' target="_blank" method="POST" action = '/affirm'>
                     @csrf
                <input style="width:400px;" name='email' id="affirm-email" type="email" class="form-control-blue" required autocomplete="email" autofocus placeholder="{{ __('EMail') }}">
                     <input type="hidden" name="affirmed" id="affirmed" value="Yes">
                <br/>
                     <input type="submit" class="btn btn-primary affirm" value="I can affirm"> <span class="btn btn-warning" onclick="$('#affirmed').val('No');$('#affirm-form').submit()">I cannot affirm</span></form>
                </center>
            </div>

{{--            <span id='cover-continue' onclick="$('.cover-page-modal').hide();">Continue</span>--}}

        </div>

    </div>
</div>


<div class="xxx-page-modal modals"><!-- template -->

    <div class="page-modal-inner modals-inner">

        <div class="breadcrumbs"><span class="go_home"><- Home</span></div>

        <div id="page-content"></div>

    </div>
</div>
