<script type="text/javascript">


    var QA;

  // Todo: move this to custom.js where it can be CND'd
    // Questionnaire

    $(document).ready(function(){

        $('.search-modal').show();

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

        let rel;

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
                        btn.innerHTML = "check-in";
                        btn.setAttribute('rel', cellData);
                        rel = cellData;
                        btn.setAttribute('class', 'seluser btn-success toolb');
                        cell.appendChild(btn);

                        var btn = document.createElement('button');
                        btn.innerHTML = "scan"

                        btn.setAttribute('rel', cellData);
                        rel = cellData;
                        btn.setAttribute('class', 'seluser-barcode btn-primary toolb');
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
            $('.modals').hide(); $('#barcode-go-home').hide();$('#barcode-go-results').hide();
            $('.fvalue').html('');
            if (DT !== false) {
                DT.destroy(true);
            }

        });
        $('.go_search').on('click', function() {
            $('.patient-form-modal').hide();
            $('.fvalue').html('');
            $('.provider-questionnaire-page-modal').hide();
            $('.scanner-page-modal').hide(); $('#barcode-go-home').hide();$('#barcode-go-results').hide();

            // Todo: Besure to hide anything else that might be on top of it.
        });
        $('.go_patient').on('click', function() {
            $('.provider-questionnaire-page-modal').hide();
            $('.scanner-page-modal').hide(); $('#barcode-go-home').hide();$('#barcode-go-results').hide();
            // Todo: Clear Questionnaire

            // Todo: Besure to hide anything else that might be on top of it.
        });
        $('.go_questionnaire').on('click', function() {
            $('.scanner-page-modal').hide(); $('#barcode-go-home').hide();$('#barcode-go-results').hide();
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
        $(document.body).on('click', '.seluser-barcode' ,function(){
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
                    doProviderQuestionnaire();
                    doScanner();

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

    var insuranceOnce = true;

    function doConfirmPatient(data) {

        // Display review form with Confirm button

        preloader_on();

        $('.patient-form-modal').show();

        // schedule (encounter_schedule) and site (site_profile) are an array of objects which are joined with the patient

        // Populate the patient confirmation form

        for (const [key, value] of Object.entries(data)) {
            console.log(key);
            console.log(value);
            if (key === 'schedule') {
                dateString = value[0].scheduled_time.$date;
                let date=moment(dateString).format('MM/DD/YYYY');
                let time=moment(dateString).format('h:mm a');
                //console.log(date);
                //console.log(time);
                $('#date').html(date);
                $('#time').html(time);

            } else if (key === 'schedule1') {
                console.log(value);
                let date = value.date;
                let time = value.time;
                let location = value.location;

                $('#schedule2').hide(); // show it later if we have one
                $('#schedule3').hide(); // show it later if we have one

                $('#date').html(date);
                $('#time').html(time);
                $('#location').html(location);

            } else if (key === 'schedule2') {

                console.log(value);
                let date = value.date;
                let time = value.time;
                let location = value.location;

                $('#schedule2').show();

                $('#date2').html(date);
                $('#time2').html(time);
                $('#location2').html(location);

            } else if (key === 'schedule3') {

                let date = value.date;
                let time = value.time;
                let location = value.location;
                let total_count = value.total_count;
                let more = value.more;

                $('#schedule3').show();

                $('#date3').html(date);
                $('#time3').html(time);
                $('#location3').html(location);
                $('#total_count').html(total_count);
                $('#more').html(more);

//            } else if (key === 'site') {
                //console.log(value[0]);
                //$('#location').html(value[0].name);
                //console.log(value[0]);

            } else if (key === 'phone_numbers') {
                console.log(value[0]);


                // $('#mphone').html('(Todo))'); // Todo parse phone numbers
                // $('#hphone').html('(Todo)');

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

        // Using the raw data right now

       // try {

            var strFile = 'https://erik.trackmyvaccine.com/work/i/' + $('#patient_id').val();

            console.log(strFile);

        $.ajax({
            url: strFile,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(q) {
                //console.log(q);

                QA = q;

             }
        });

            // POPULATE QUESTIONNAIRE AND SHOW WARNING ON SCANNER PAGE IF ALLERGIES


       // } catch {console.log('no Q');}

        // $("#q1").val("No");
        // $("#q2").val("No");
        // $("#q3").val("No") ;
        // $("#q4").val("No");
        // $("#q5").val("No");
        // $("#q6").val("No");

        // $("#q1Yes").removeClass( "RedSelect" );
        // $("#q1No").addClass( "GreenSelect" );
        // $("#q2Yes").removeClass( "RedSelect" );
        // $("#q2No").addClass( "GreenSelect" );
        // $("#q3Yes").removeClass( "RedSelect" );
        // $("#q3No").addClass( "GreenSelect" );
        // $("#q4Yes").removeClass( "RedSelect" );
        // $("#q4No").addClass( "GreenSelect" );

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
    function doProviderQuestionnaire() {

        // populate the questionnaire during the business above

        $('.provider-questionnaire-page-modal').show();

        return false;

    }
    function doScanner() {

       // console.log('scanner');

        $('.scanner-page-modal').show();
        $('#barcode-results').html('');
        $('#barcode-input').val('').focus();
        $('#barcode-form').show();
        $('#barcode-go-home').hide();

        if (QA.q6 == 'Yes') {

            $('#barcode-allergy').show();

        } else {
            $('#barcode-allergy').hide();
        }


        return false;

    }

    var BCTIMEOUT=0;

    function doHandleBarcode() {

        let barcode = $('#barcode-input').val();
        let adminsite = $('#admin-site').val();

        $.ajax({
            url: '/biq/barcode',
            data: 'adminsite=' + adminsite + '&barcode=' + barcode + '&patient_id=' + $('#patient_id').val(),
            dataType: 'text',
            success: function(o) {

                $('#barcode-results').html(o);
                $('#barcode-input').val('').focus();
                $('#barcode-form').hide();
                $('#barcode-go-home').show();


            },
            error: function() {
                preloader_off();
                // Todo: handle this more elegantly
                alert('An error has occurred');
            },
        });





  }
</script>
