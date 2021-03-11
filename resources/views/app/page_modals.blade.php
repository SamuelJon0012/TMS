<div class="adverse-event-form-page-modal modals">

    <div class="page-modal-inner modals-inner">

        <div class="breadcrumbs"><span class="go_home"><- {{ __('Home') }}</span></div>

        <div id="page-content"></div>

    </div>
</div>
<div class="alerts-page-modal modals">

    <div class="page-modal-inner modals-inner">

        <div class="breadcrumbs"><span class="go_home"><- {{ __('Home') }}</span></div>

        <div id="page-content"></div>

    </div>
</div>
<div class="patient-settings-page-modal modals">

    <div class="page-modal-inner modals-inner">

        <div class="breadcrumbs"><span class="go_home"><- {{ __('Home') }}</span></div>

        <div id="page-content"></div>

    </div>
</div>
<div class="provider-settings-page-modal modals">

    <div class="page-modal-inner modals-inner">

        <div class="breadcrumbs"><span class="go_home"><- {{ __('Home') }}</span></div>

        <div id="page-content"></div>

    </div>
</div>
<div class="cover-page-modal modals">

    <div class="page-modal-inner modals-inner">

        <div id="page-content">

            <!-- Eventually make this the CDN/Bucket Cover Page -->

            <h1>{{ __('Affirmation Statement') }}</h1>
            <div>
                {{ __('I affirm that I meet one of the 1A criteria listed below') }}
            </div>

            <div>
                <ul>
                    <li>{{ __('Health care personnel including, but not limited to:')}}</li>
                    <ul>
                        <li>{{ __('Emergency medical service personnel') }}</li>
                        <li>{{ __('Nurses') }}</li>
                        <li>{{ __('Physicians') }}</li>
                        <li>{{ __('Dentists') }}</li>
                        <li>{{ __('Dental hygienists') }}</li>
                        <li>{{ __('Chiropractors') }}</li>
                        <li>{{ __('Therapists') }}</li>
                        <li>{{ __('Phlebotomists') }}</li>
                        <li>{{ __('Pharmacists') }}</li>
                        <li>{{ __('Technicians') }}</li>
                        <li>{{ __('Pharmacy technicians') }}</li>
                        <li>{{ __('Health professions students and trainees') }}</li>
                        <li>{{ __('Direct support professionals') }}</li>
                        <li>{{ __('Clinical personnel in school settings or correctional facilities') }}</li>
                        <li>{{ __('Contractual HCP not directly employed by the health care facility') }}</li>
                        <li>{{ __('Persons not directly involved in patient care but potentially exposed to infectious material that can transmit disease among or from health care personnel and patients') }}</li>
                        <li>{{ __('Persons ages 65 and older') }}</li>
                        <li>{{ __('Persons ages 16-64 with high risk conditions') }}</li>
                    </ul>
                    <li>{{ __('Cancer') }}</li>
                    <li>{{ __('COPD') }}</li>
                    <li>{{ __('Down Syndrome') }}</li>
                    <li>{{ __('Heart conditions, such as heart failure, coronary artery disease, or cardiomyopathies') }}</li>
                    <li>{{ __('Immunocompromised state (weakened immune system) from solid organ transplant or from blood or bone marrow transplant, immune deficiencies , HIV, use of corticosteroids, or use of other immune weakening medicines') }}</li>
                    <li>{{ __('Obesity (BMI of 30 kg/m2 or higher but &#62 40 kg/m2)') }}</li>
                    <li>{{ __('Severe obesity (BMI &#8805 40 kg/m2)') }}</li>
                    <li>{{ __('Pregnancy') }}</li>
                    <li>{{ __('Sickle cell disease') }}</li>
                    <li>{{ __('Smoking') }}</li>
                    <li>{{ __('Type 2 diabetes mellitus') }}</li>
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
                     <input type="submit" class="btn btn-primary affirm" value="I can affirm"> <span class="btn btn-warning" onclick="$('#affirmed').val('No');$('#affirm-form').submit()">{{ __('I cannot affirm') }}</span></form>
                </center>
            </div>

{{--            <span id='cover-continue' onclick="$('.cover-page-modal').hide();">Continue</span>--}}

        </div>

    </div>
</div>


<div class="xxx-page-modal modals"><!-- template -->

    <div class="page-modal-inner modals-inner">

        <div class="breadcrumbs"><span class="go_home"><- {{__('Home')}}</span></div>

        <div id="page-content"></div>

    </div>
</div>
