@once
@push('pageBottom')
<script> 
$(function(){
    
    frmTestQuestions.handleSelfTestingSelected = function(selectedValue){
        frmTestQuestions.isSelfTesting.value = selectedValue;
        Modals.show('patient-COVID-test2-modal');
    }

    frmTestQuestions.valuesForCheckBoxes = function(control){
        var res = [];
        for(var e of control){
            if (e.checked)
              res.push(e.value);
        }
        return res;
    }

    frmTestQuestions.setCheckBoxes = function(control, list){
        for(var e of control){
            e.checked = (list.indexOf(e.value) != -1);
        }
    }

    frmTestQuestions.symptoms.asArray = function(){
        return frmTestQuestions.valuesForCheckBoxes(frmTestQuestions.symptoms);
    }

    frmTestQuestions.issues.asArray = function(){
        return frmTestQuestions.valuesForCheckBoxes(frmTestQuestions.issues);
    }

    frmTestQuestions.setError = function(element, message){
        if (typeof element == 'string')
            element = document.getElementById(element);
        if (element == null)
            throw new Error('[frmTestQuestions.setError] invalid element');

        for(var e of element.querySelectorAll('.invalid-feedback'))
            e.parentNode.removeChild(e);

        if (message){
            var e = document.createElement('SPAN');
            e.className = 'invalid-feedback';
            e.setAttribute('role','alert');
            e.innerHTML = message;
            element.appendChild(e);
        }
    }

    frmTestQuestions.clearErrors = function(){
        for (var e of frmTestQuestions.querySelectorAll('.invalid-feedback'))
          e.parentNode.removeChild(e);
    }

    frmTestQuestions.validateNumberInput = function(control){
        if ((typeof control != 'object') || (control.nodeName != 'INPUT'))
          throw new Error('[frmTestQuestions.validateNumberInput] Invalid control');

        if (!control.value)
          return '<?=__('please complete')?>' ;

        var value = parseInt(control.value);
        if (isNaN(value))
          return '<?=__('invalid')?>';

        var max = parseInt(control.max);
        if ((!isNaN(max)) && (value > max))
            return '<?=__('too high')?>';

        var min = parseInt(control.min);
        if ((!isNaN(min)) && (value < min)) 
          return '<?=__('too low')?>';
    }

    frmTestQuestions.validate = function(){
        var frm = frmTestQuestions;
        var jumpTo = null;
        var err = null;

        frm.clearErrors();

        if (frm.hasSevereSymptoms.value == ''){
            frm.setError('hasSevereSymptoms_error', '<?=__('Please select one')?>');
            jumpTo = jumpTo || frm.hasSevereSymptoms;
        }

        if (frm.hasCloseContact.value == ''){
            frm.setError('hasCloseContact_error', '<?=__('Please select one')?>');
            jumpTo = jumpTo || frm.hasCloseContact;
        }

        if (frm.wasInfected.value == ''){
            frm.setError('wasInfected_error', '<?=__('Please select one')?>');
            jumpTo = jumpTo || frm.wasInfected;
        }

        if (frm.symptoms.asArray().length == 0){
            frm.setError('symptoms_error', '<?=__('Please select at least None')?>');
            jumpTo = jumpTo || frm.symptoms;
        }

        if (frm.issues.asArray().length == 0){
            frm.setError('issues_error', '<?=__('Please select at least None')?>');
            jumpTo = jumpTo || frm.issues;
        }

        if (frm.phoneMessage.value == ''){
            frm.setError('phoneMessage_error', '<?=__('Please select one')?>');
            jumpTo = jumpTo || frm.phoneMessage;
        }

        if (err = frm.validateNumberInput(frm.heightFeet)){
            frm.setError('heightFeet_error', err);
            jumpTo = jumpTo || frm.heightFeet;
        }

        if (err = frm.validateNumberInput(frm.heightInch)){
            frm.setError('heightInch_error', err);
            jumpTo = jumpTo || frm.heightInch;
        }

        if (err = frm.validateNumberInput(frm.weight)){
            frm.setError(frm.weight.parentNode, err);
            jumpTo = jumpTo || frm.weight;
        }

        if (!frm.consent.checked){
            frm.setError(frm.consent.parentNode, '<?=__('please tick this')?>');
            jumpTo = jumpTo || frm.consent;
        }

        if (jumpTo){
            if (jumpTo.scrollIntoView != undefined)
                jumpTo.scrollIntoView();
            else if (jumpTo[0].scrollIntoView != undefined)
                jumpTo[0].scrollIntoView();
        }

        return (jumpTo == null);
    }

    frmTestQuestions.getData = function(){
        var frm = frmTestQuestions;
        var res = {};
        res._token = frm._token.value;
        res.isSelfTesting = (frm.isSelfTesting.value == 'yes');
        res.hasSevereSymptoms = (frm.hasSevereSymptoms.value == 'yes');
        res.hasCloseContact = frm.hasCloseContact.value;
        res.wasInfected = (frm.wasInfected.value == 'yes');
        res.symptoms = frm.symptoms.asArray();
        res.issues = frm.issues.asArray();
        res.phoneMessage = (frm.phoneMessage.value == 'yes');
        res.heightFeet = parseInt(frm.heightFeet.value);
        res.heightInch = parseInt(frm.heightInch.value);
        res.weight = parseInt(frm.weight.value);
        res.consent = frm.consent.checked;
        return res;
    }

    frmTestQuestions.setData = function(obj){
        if (typeof obj == 'string')
          obj = JSON.parse(obj);

        var frm = frmTestQuestions;

        frm.isSelfTesting.value = obj.isSelfTesting;
        frm.hasSevereSymptoms.value = (obj.hasSevereSymptoms) ? 'yes' : 'no';
        frm.hasCloseContact.value = obj.hasCloseContact;
        frm.wasInfected.value = (obj.wasInfected) ? 'yes' : 'no';
        frm.setCheckBoxes(frm.symptoms, obj.symptoms);
        frm.setCheckBoxes(frm.issues, obj.issues);
        frm.phoneMessage.value = (obj.phoneMessage) ? 'yes' : 'no';
        frm.heightFeet.value = obj.heightFeet;
        frm.heightInch.value = obj.heightInch;
        frm.weight.value = obj.weight;
        frm.consent.checked = obj.consent;

        frm.validate();
    }

    frmTestQuestions.send = function(){
        if (!frmTestQuestions.validate())
            return;
        preloader_on();
        frmTestQuestions.btnSubmit.disabled = true;

        decorateAjax(
            $.ajax({
                type: "POST",
                url:'/patient-test',
                data: JSON.stringify(frmTestQuestions.getData()),
                processData: false,
                contentType: 'application/json',
            })
            .then(function(data){
                checkAjaxResult(data);
                frmTestQuestions.setData(data);
                Modals.show('patient-COVID-test3-modal');
            })
        );
    }
});
</script>

<style>
    .patient-COVID-test-self-question{
        text-align: center;
        margin: 1pc auto;
        max-width: 32pc;
    }
    .patient-COVID-test-self-row{
        display: flex;
        margin: 1pc auto;
        max-width: 32pc;
        flex-flow: row;
    }
    .patient-COVID-test-self-item{
        cursor:pointer;
        border-radius: 12px;
        border: 1px solid var(--blue);
        flex: 1 1;
        display: flex;
        align-items: center;
        margin: 1pc;
        padding: 1pc;
        text-align: center;
        min-height: 12pc;
    }
    .patient-COVID-test-self-item:hover{
        background-color: #ddeeff; 
    }
    .patient-COVID-test-self-group{

    }
    .patient-COVID-test-self-group td{
        padding-bottom: 0.5pc;
    }
    .patient-COVID-test-self-group td:first-child{
        padding-right:0.5pc;
    }
    .patient-COVID-test-lastRow{
        flex-flow: row;
        display: flex;
    }
    .patient-COVID-test-lastRow > div{
        flex: 1 1;
    }
    #patient-COVID-test2-modal input[type=number]{
        width: 5pc;
        border-radius: 0.5pc;
        border: 1px solid silver;
        padding: 0.1pc;
        text-align: center;
    }
    .patient-COVID-test-submit{
        max-width: 48pc;
        margin: 0 auto;
        text-align: center;
    }
    .patient-COVID-test-submit button{
        max-width: 28pc;
        margin: 2pc auto;  
    }
    
    body #frmTestQuestions .invalid-feedback{ /* override mixin for this form*/
        display: inherit;
    }

    #patient-COVID-test-thankyou{
        position: absolute;
        bottom: 50%;
        left: 50%;
        transform: translate(-50%, 0);
        text-align: center;
        font-weight:bold;
        font-size: 140%;
    }
    
    @media(max-width: 32pc){
        .patient-COVID-test-self-row{
            flex-direction: column;
        }
        .patient-COVID-test-self-item{
            min-height: unset;
        }
        .patient-COVID-test-lastRow{
            flex-direction: column;
        }
        #patient-COVID-test-thankyou{
            position: inherit;
            bottom:unset;
            left:unset;
            transform:unset;
            margin: 2pc 0.5pc;
        }
    }
    @media(max-height: 32pc){
        #patient-COVID-test-thankyou{
            position: inherit;
            bottom:unset;
            left:unset;
            transform:unset;
            margin: 2pc 0.5pc;
        }
    }
</style>
@endpush
@endonce


{{-- -------------------------------------------------------------------------- Choice between self and facility testing --}}
@component('controls.modal', [
    'id'=>'patient-COVID-test1-modal',
    'breadCrumbs'=>[
        ['caption'=>'home'],
    ]
])
    <div class="patient-COVID-test-self-question">
        {{ __('Are you performing a COVID test at a facility or are you going to preform a self-given sample collection and send to testing lab?') }}
    </div>
    <div class="patient-COVID-test-self-row">
        <div class="patient-COVID-test-self-item" onclick="frmTestQuestions.isSelfTesting='no'; frmTestQuestions.handleSelfTestingSelected('no')">
            {{ __('Performing COVID Test at ON-SITE testing facility') }}
        </div>
        <div class="patient-COVID-test-self-item" onclick="frmTestQuestions.handleSelfTestingSelected('yes')">
            {{ __('Performing self-given COVID test sample collection and sending to testing lab') }}
        </div>
    </div>
@endcomponent


{{-- -------------------------------------------------------------------------- COVID-19 test Questionnaire  --}}
@component('controls.modal',[
    'id'=>'patient-COVID-test2-modal',
    'breadCrumbs'=>[
        ['caption'=>'home'],
        ['id'=>'patient-COVID-test1-modal','caption'=>'Facility'],
    ]
])
    <?php
        function MakeRadioGroup($name, $items){
            echo '<table class="patient-COVID-test-self-group">';
            foreach($items as $value=>$caption)
                echo '<tr><td><input name="'.$name.'" type="radio" value="'.$value.'"/></td> <td>'.__($caption).'</td></tr>';
            echo '</table>';
        }
        function MakeCheckBoxGroup($name, $items){
            echo '<table class="patient-COVID-test-self-group">';
            foreach($items as $ident=>$caption)
                echo '<tr><td><input name="'.$name.'" value="'.$ident.'" type="checkbox"/></td> <td>'.__($caption).'</td></tr>';
            echo '</table>';
        }
    ?>

    <form name="frmTestQuestions" id="frmTestQuestions" action="" onsubmit="return false;">
        @csrf
        <input type="hidden" name="isSelfTesting" value="no"/>

        <p><b>{{ __('Welcome to Your COVID-19 Viral Test Assessment') }}</b></p>

        <div class="form-group">
            <p>{{ __('The COVID-19 PCR-Nasal Swab is a test to see if you are currently infected with COVID-19.') }}</p>
        
            <b>{{ __('Do you currently have any of the following severe symptoms?') }}</b>
            <ul style="list-style: decimal; font-weight: bold;">
                <li>{{ __('Trouble breathing') }}</li>
                <li>{{ __('Persistent pain or pressure in the chest') }}</li>
                <li>{{ __('New confusion') }}</li>
                <li>{{ __('Inability to wake or stay awake') }}</li>
                <li>{{ __('Bluish lips or face') }}</li>
            </ul>

            <?php
            MakeRadioGroup('hasSevereSymptoms',[
                'yes'=>'Yes',
                'no'=>'No'
            ]);
            ?>
            <div id="hasSevereSymptoms_error"></div>
        </div>
        

        <div class="form-group">
            <b>{{ __('Have you been in contact with someone who tested positive for COVID-19 or a place where COVID-19 is spreading in the last 2 weeks?') }}</b>

            <?php
            MakeRadioGroup('hasCloseContact',[
                'no'=>'No, I have not.',
                'community'=>'Yes, there have been cases of COVID-19 in my community',
                'confirmed'=>'Yes, I have been in contact with someone with a confirmed case of COVID-19',
                'notConfirmed'=>'Yes, I have been in contact with someone with COVID-19 symptoms, but they have not been tested yet.'
            ]);
            ?>
            <div id="hasCloseContact_error"></div>
        </div>

        <div class="form-group">
            <b>{{ __('Have you previously been diagnosed with COVID-19?') }}</b>
            <?php
            MakeRadioGroup('wasInfected',[
                'yes'=>'Yes',
                'no'=>'No'
            ]);
            ?>
            <div id="wasInfected_error"></div>
        </div>

        <div class="form-group" id="frmTestQuestions_symptoms">
            <b>{{ __('Which of the following symptoms do you have? (Check all that apply)') }}</b>
            <?php
            MakeCheckBoxGroup('symptoms', [
                'temperatureBelow100'=>'Temperature never above (100 deg)',
                'temperatureAbove100'=>'Fever (temperature over 100 deg)',
                'chills'=>'Chills / Shaking',
                'sweats'=>'Sweats',
                'headache'=>'Headache',
                'chestPain'=>'Chest pain or tightness',
                'difficultyBreathing'=>'Short of breath / Difficulty breathing',
                'tired'=>'Lack of energy',
                'aches'=>'Muscle / Body aches',
                'fatigue'=>'Muscle weakness / Fatigue',
                'arthritic'=>'Arthritic / Joint pain',
                'numbness'=>'Tingling / Numbness in hast or feet',
                'rash'=>'Rash / Skin irritation',
                'taste'=>'Lack of taste and/or smell',
                'appetite'=>'Lack of appetite',
                'insomnia'=>'Could not sleep / insomnia',
                'sleepy'=>'Could do nothing but sleep',
                'dizziness'=>'Dizziness / Vertigo',
                'confusion'=>'Delirium / Confusion / Inability to focus',
                'dryCough'=>'Dry cough',
                'wetCough'=>'Productive (wet cough)',
                'congestion'=>'Sinus congestion / Stuff nose',
                'mucus'=>'Mucus / Phlegm',
                'soreThroat'=>'Sore throat',
                'stomachPain'=>'Stomach Pain',
                'none'=>'None'
            ]);
            ?>
            <div id="symptoms_error"></div>
        </div>


        <div class="form-group" id="frmTestQuestions_issues">
            <b>Medical issues</b>
            <?php
            MakeCheckBoxGroup('issues', [
                'aids'=>'AIDS',
                'autoimmune'=>'Autoimmune',
                'cancer'=>'Cancer',
                'cancerTreatment'=>'Cancer Treatment (Currently)',
                'diabetes'=>'Diabetes',
                'heartDisease'=>'Hart Disease',
                'hiv'=>'HIV',
                'lungDisease'=>'Lung Disease (COPD. Asthma)',
                'liverDisease'=>'Liver Disease',
                'pregnant'=>'Pregnant',
                'smoker'=>'Smoker',
                'otherChronic'=>'Other Chronic Disease such as Chronic Kidney Disease',
                'none'=>'None'
            ]);
            ?>
            <div id="issues_error"></div>
        </div>

        <div class="form-group">
            <b>May we leave a message on your phone?</b>
            <?php
            MakeRadioGroup('phoneMessage',[
                'yes'=>'Yes',
                'no'=>'No'
            ]);
            ?>
            <div id="phoneMessage_error"></div>

            <br/>
            <p><strong>Please provide your Height and Weight?</strong></p>
            <table>
                <tr>
                    <td>Height: </td>
                    <td><input name="heightFeet" type="number" placeholder="Feet" min="0" max="20"/> </td>
                    <td>&nbsp;</td>
                    <td><input name="heightInch" type="number" placeholder="Inches" min="0" max="11"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td id="heightFeet_error"></td>
                    <td></td>
                    <td id="heightInch_error"></td>
                </tr>
                <tr>
                    <td>Weight: </td>
                    <td><input name="weight" type="number" placeholder="Pounds" min="10" max="1000"/></td>
                </tr>
            </table>
        </div>

        <div class="form-group">
            <div class="patient-COVID-test-submit">
                <div>
                    <input type="checkbox" name="consent"/>
                    <span>{{ __('I agree to share the above answers for the purpose of signing up for the COVID-19 test.') }}</span>
                </div>
                <div>
                    <button id="btnSubmit" class="btn btn-primary form-control" onclick="this.form.send()">{{ __('Submit') }}</button>
                </div>
            </div>
        </div>

    </form>

@endcomponent


{{-- -------------------------------------------------------------------------- Thank you --}}

@component('controls.modal',[
    'id'=>'patient-COVID-test3-modal',
    'breadCrumbs'=>[
        ['caption'=>'home'],
        ['id'=>'patient-COVID-test1-modal','caption'=>'Facility'],
        ['id'=>'patient-COVID-test2-modal','caption'=>'Questions']
    ]
])

    <div id="patient-COVID-test-thankyou">
        <p>Thank you for submitting your answers.</p>
        <p>You may now proceed to the patient testing area!</p>
    </div>

@endcomponent