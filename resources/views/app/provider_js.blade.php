// Todo: move this to custom.js where it can be CND'd

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

    // End Questionnaire


    var input, dtData = [], DT=false;
    function doCreateTable(tableData) {
        var table = document.createElement('table');
        table.setAttribute("id", "search-table");
        table.setAttribute("class", "stripe");
        var tableHead = document.createElement('thead');
        var tableBody = document.createElement('tbody');

        let once = true;

        let row;

        tableData.forEach(function(rowData) {

            let first=true;

            if (once) {
                row = document.createElement('tr');

                rowData.forEach(function (cellData) {
                    var cell = document.createElement('th');
                    cell.appendChild(document.createTextNode(cellData));
                    row.appendChild(cell);
                });

                tableHead.appendChild(row);
                once=false;

            } else {

                row = document.createElement('tr');
                rowData.forEach(function (cellData) {
                    var cell = document.createElement('td');

                    if (first) {
                        var btn = document.createElement('button');
                        btn.innerHTML = "+";
                        btn.setAttribute('rel', cellData);
                        btn.setAttribute('class', 'seluser');
                        cell.appendChild(btn);
                        first = false;
                    } else {
                        cell.appendChild(document.createTextNode(cellData));

                    }

                    row.appendChild(cell);
                });

                tableBody.appendChild(row);
            }
        });

        table.appendChild(tableHead);
        table.appendChild(tableBody);
        $('#search-results').html('');
        document.getElementById("search-results").appendChild(table);
    }


    function doPatientSearch(inputId) {
        //console.log('doPatientSearch');
        input = $('#' + inputId).val();
        preloader_on();
        setTimeout(function() {
            $.ajax({
                url: '/biq/find',
                data: 'i=' + inputId + '&q=' + input,
                dataType: 'json',
                success: function(o) {

                    // Todo: Check for an error object (success = false) or unexpected data

                    data = o.data;

                    let row, btn;

                    dtData = [['','Patient Name', 'Date of Birth', 'Patient Email', 'Patient Phone']] ;

                    data.forEach(function(row) {

                        dtData[dtData.length] =
                            [
                                row.id, row.first_name + ' ' + row.last_name,
                                row.date_of_birth.$date.replace('T00:00:00.000Z',''),
                                row.email,
                                row.phone_numbers[0].phone_number
                            ];
                    });

                    //console.log('dtData');
                    //console.log(dtData);

                    // Todo: hide the #search-results div while this is taking place? mebs

                    if (DT !== false) {
                        DT.destroy(true);
                    }
                    doCreateTable(dtData);
                    DT = $('#search-table').DataTable({
                        'searching': false,
                        'paging': false,
                        'scrollY': 300

                    });
                    //console.log('DT');
                    //console.log(DT);
                    preloader_off();
                },
                error: function() {
                    preloader_off();

                    // Todo: handle this more elegantly
                    alert('An error has occurred');

                },

            });
        },100);
        return false;
    }
    //setTimeout(function() {
    $(function() {
        $.noConflict();

        $('.go_home').on('click', function() {
            $('.modals').hide();
            $('.fvalue').html('');
            if (DT !== false) {
                DT.destroy(true);
            }

        });
        $('.go_search').on('click', function() {
            $('.patient-form-modal').hide();
            $('.fvalue').html('');
            $('.provider-questionnaire-page-modal').hide();
            $('.scanner-page-modal').hide();

            // Todo: Besure to hide anything else that might be on top of it.
        });
        $('.go_patient').on('click', function() {
            $('.provider-questionnaire-page-modal').hide();
            $('.scanner-page-modal').hide();
            // Todo: Clear Questionnaire

            // Todo: Besure to hide anything else that might be on top of it.
        });
        $('.go_questionnaire').on('click', function() {
            $('.scanner-page-modal').hide();
            // Todo: Clear Scanner Page

            // Todo: Besure to hide anything else that might be on top of it.
        });
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
        $('.patient-button').on('click', function() {
            $('.search-modal').show();
        });
        $('.provider-search').on('click', function() {
            $('.provider-search-modal').show();
        })
        $('.set-vaccine-location').on('click', function() {
            $('.set-vaccine-location-modal').show();
        })
    });


    function doConfirmPatient(data) {

        // Display review form with Confirm button

        preloader_on();

        $('.patient-form-modal').show();

        // schedule (encounter_schedule) and site (site_profile) are an array of objects which are joined with the patient

        // Populate the patient confirmation form

        for (const [key, value] of Object.entries(data)) {
            //console.log(key);
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
                //console.log(value[0]);
                for (const [key, ovalue] of Object.entries(value[0])) {

                    // Todo: iterating once in here checks Yes on the private insurance question and opens the thing


                    console.log(`${key}: ${ovalue}`);
                    if (key === 'coverage_effective_date') {
                        console.log(ovalue);
                        dateString = ovalue.$date;
                        let date=moment(dateString).format('MM/DD/YYYY');
                        let time=moment(dateString).format('h:mm a');
                        console.log(date);
                        console.log(time);
                        // This goes in to questionnaire area
                        //$('#date').html(date);
                        //$('#time').html(time);

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

            // (hard coded right now)

        $("#q1Yes").removeClass( "RedSelect" );
        $("#q1No").addClass( "GreenSelect" );
        $("#q2Yes").removeClass( "RedSelect" );
        $("#q2No").addClass( "GreenSelect" );
        $("#q3Yes").removeClass( "RedSelect" );
        $("#q3No").addClass( "GreenSelect" );
        $("#q4Yes").removeClass( "RedSelect" );
        $("#q4No").addClass( "GreenSelect" );

    // Populate the insurance form




        // Todo: Break out the hphone and mphone if present

        preloader_off();
    }
    function doProviderQuestionnaire() {

        // populate the questionnaire during the business above

        $('.provider-questionnaire-page-modal').show();


        return false;

    }
    function doScanner() {

       // console.log('scanner');


        $('.scanner-page-modal modals').show();


        return false;

    }

</script>
