<div class="my-vaccine-page-modal modals">

    <div class="page-modal-inner modals-inner">

        <div class="breadcrumbs"><span class="go_home"><- Home</span></div>

        <div id="page-content"></div>

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
                I affirm that I work with low incidence students and I meet one the of the 1A criteria listed below
            </div>

            <div>
                <ul>
                    <li>Health care personnel including, but not limited to:</li>
                    <ul>
                        <li>Emergency medical service personnel</li>
                        <li>Nurses</li>
                        <li>Physicians</li>
                        <li>Dentists</li>
                        <li>Dental hygenists</li>
                        <li>Chiropractors</li>
                        <li>Therapists</li>
                        <li>Phlebotomists</li>
                        <li>Pharmacists</li>
                        <li>Technicians</li>
                        <li>Pharamacy technicians</li>
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

<div class="help-page-modal modals"><!-- template -->

    <div class="page-modal-inner modals-inner">

        <div class="breadcrumbs"><span class="go_home"><- Home</span></div>

        <div id="page-content">


            <h1 style="text-align:center;">TrackMy Vaccines Help</h1>

            <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
                <main role="main" class="inner cover">
                    <div id="viewer-div" rel="/files/default/help.html?601da043ace03">
                        <h3>Welcome to TrackMy Vaccines a feature of TrackMy Solutions&#153</h3>
                        <p>At TrackMy we are focused on the Double E, Double I of Healthcare - E²i² (Engage, Educate, Inform, Involve), thus anything we can do to assist you with
                            scheduling your vaccine appointment or ensuring your vaccination data is readily available to you, please do not hesitate to reach out.</p>

                        <h2>Patient Call Center:  1-844-522-5952</h2>
                        <p>9am-5pm 7 days a week EST</p>

                    </div>
                </main>
            </div>


        </div>

    </div>
</div>

<div class="xxx-page-modal modals"><!-- template -->

    <div class="page-modal-inner modals-inner">

        <div class="breadcrumbs"><span class="go_home"><- Home</span></div>

        <div id="page-content"></div>

    </div>
</div>
