<script type="text/javascript">

    // Questionnaire

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
                $("#have_insurance_no, #have_insurance_yes").removeAttr('disabled')
                $('#no-appointment').hide();
            }
            else
            {
                $("#subBtn").addClass( "disabled" )
                $("#have_insurance_no, #have_insurance_yes").attr('disabled', true)
                $('#no-appointment').show();
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
    // End Questionnaire


    var insuranceOnce = true;

    function doConfirmPatient(data) {

        // Display review form with Confirm button

        preloader_on();

        $('.patient-form-modal').show();

        // schedule (encounter_schedule) and site (site_profile) are an array of objects which are joined with the patient

        // Todo: Populate the patient confirmation form to allow patient to edit their profile

        for (const [key, value] of Object.entries(data)) {
            console.log(key);
            if (key === 'schedule') {
                dateString = value[0].scheduled_time.$date;
                let date=moment(dateString).format('MM/DD/YYYY');
                let time=moment(dateString).format('h:mm a');
                //console.log(date);
                //console.log(time);
                $('#date').html(date);
                $('#time').html(time);

            } else if (key === 'site') {
                //console.log(value[0]);
                $('#location').html(value[0].name);

            } else if (key === 'phone_numbers') {
                console.log(value[0]);
                $('#mphone').html('727-555-1212');
                $('#hphone').html('727-555-1212');

            } else if (key === 'insurances') {

                console.log('insurances');

                if (insuranceOnce) {

                    insuranceOnce = false; // Only populate the insurance form with the primary insurance

                    for (const [okey, ovalue] of Object.entries(value[0])) {

                        console.log(`${okey}: ${ovalue}`);

                        if (okey === 'coverage_effective_date') {

                            console.log(ovalue);
                            dateString = ovalue.$date;
                            let date = moment(dateString).format('MM/DD/YYYY');
                            let time = moment(dateString).format('h:mm a');
                            console.log(date);
                            console.log(time);
                            $('#coverage_effective_date').val(date);


                        } else {

                            $('#' + okey).val(ovalue);
                        }

                    }
                }



            } else if (key === 'id') { // Todo: This becomes patient ID after implementing patient-schedule-site-query
                //console.log(value);
                $('#patient_id').val(value);
            }else {

                //console.log(`${key}: ${value}`);
                $('#' + key).html(value);
            }
        }

        // Populate the Questionnaire questions from encounter_schedule

        // (hard coded "No" answers right now)

        $("#q1").val("No");
        $("#q2").val("No");
        $("#q3").val("No") ;
        $("#q4").val("No");

        $("#q1Yes").removeClass( "RedSelect" );
        $("#q1No").addClass( "GreenSelect" );
        $("#q2Yes").removeClass( "RedSelect" );
        $("#q2No").addClass( "GreenSelect" );
        $("#q3Yes").removeClass( "RedSelect" );
        $("#q3No").addClass( "GreenSelect" );
        $("#q4Yes").removeClass( "RedSelect" );
        $("#q4No").addClass( "GreenSelect" );

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

        if (!insuranceOnce) {
            // iterating once Checks Yes on the private insurance question and opens the thing
            $("#have_insurance_yes").click(function () {

                $("#insuranceSection").show();
                $("#administrator_name, #group_id, #coverage_effective_date, #primary_cardholder, #issuer_id, #insurance_type").attr('required', true);
            });
            $("#have_insurance_yes").click();

        }

        preloader_off();
    }
    function doPatientQuestionnaire() {

        // populate the questionnaire during the business above
        console.log('boo');

        $('.patient-questionnaire-page-modal').show();

        return false;

    }



    $(function() {
        $.noConflict();

        $('.go_home').on('click', function() {
            $('.modals').hide();
            });


        // Todo: Modify the code in this listener to get the Patient data from BurstIq and doConfirmPatient() to populate form

        $(document.body).on('click', '.seluser' ,function(){
            preloader_on();
            let id = $(this).attr('rel');

            $.ajax({
                url: '/biq/get',
                data: 'q=' + id,
                dataType: 'json',
                success: function(o) {

                    // Todo: Check for an error object (success = false) or unexpected data

                    //console.log('o');
                    //console.log(o);

                    // Todo: Confirm o.data[0] exists

                    doConfirmPatient(o.data[0]);

                },
                error: function() {
                    preloader_off();
                    // Todo: handle this more elegantly
                    alert('An error has occurred');
                },
            });

        });

    });


</script>
