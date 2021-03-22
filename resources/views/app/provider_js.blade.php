<script type="text/javascript">


    var QA;

    // Questionnaire



    $(document).ready(function(){

        $('#myvaccine-button').on('click', function() {

            Modals.show('my-vaccine-page-modal');
            preloader_on();
            decorateAjax(
                $.ajax({
                    url: '/biq/myVaccines',
                    data: 'q=' + {{ Auth::user()->id }},
                    dataType: 'text',
                    success: function(o) {
                        if (checkAjaxResponse(o))
                            $('#my-vaccine-info').html(o);
                    },
                })
            );

            $('.adverse-event').on('click', function() {
                alert('This feature is not currently available');
            })

        });


        $(".Qoption").click(function(){
            var oResult = $(this).attr('rel');
            var oResultArr = oResult.split("_");
            var oNumber = oResultArr[1]
            var oValue = oResultArr[0]

            $("#q"+oNumber).val(oValue);
            if(oValue == "Yes")
            {

                if ((oNumber == 5) || (oNumber == 6)) {

                    $("#q"+oNumber+"Yes").addClass( "GreySelect" )
                    $("#q"+oNumber+"No").removeClass( "GreySelect" )

                } else {

                    $("#q"+oNumber+"Yes").addClass( "RedSelect" )
                    $("#q"+oNumber+"No").removeClass( "GreenSelect" )

                }

            }
            else if(oValue == "No")
            {
                if ((oNumber == 5) || (oNumber == 6)) {

                    $("#q"+oNumber+"Yes").removeClass( "GreySelect" )
                    $("#q"+oNumber+"No").addClass( "GreySelect" )

                } else {

                    $("#q"+oNumber+"Yes").removeClass( "RedSelect" )
                    $("#q"+oNumber+"No").addClass( "GreenSelect" )

                }
            }
            else
            {
                $("#q"+oNumber+"Yes").removeClass( "RedSelect" )
                $("#q"+oNumber+"No").removeClass( "GreenSelect" )
            }

            // We don't care about Q5

            // if($("#q1").val() == "No" && $("#q2").val() == "No" && $("#q3").val() == "No" && $("#q4").val() == "No")
            // {
            //     $("#subBtn").removeClass( "disabled" )
            //     $("#have_insurance_no, #have_insurance_yes").removeAttr('disabled')
            //     $('#no-appointment').hide();
            // }
            // else
            // {
            //     $("#subBtn").addClass( "disabled" )
            //     $("#have_insurance_no, #have_insurance_yes").attr('disabled', true)
            //     $('#no-appointment').show();
            // }

            // if(
            //     (
            //
            //         $("#q1").val() == "Yes" || $("#q2").val() == "Yes" || $("#q3").val() == "Yes" || $("#q4").val() == "Yes"
            //     )
            //
            //     // If there's a yes in 1-5 AND every Q has an A
            //
            //     && ($("#q1").val() == "Yes" || $("#q1").val() == "No")
            //     && ($("#q2").val() == "Yes" || $("#q2").val() == "No")
            //     && ($("#q3").val() == "Yes" || $("#q3").val() == "No")
            //     && ($("#q4").val() == "Yes" || $("#q4").val() == "No")
            //     && ($("#q5").val() == "Yes" || $("#q5").val() == "No")
            //     && ($("#q6").val() == "Yes" || $("#q6").val() == "No")
            //
            // ) {
            //
            //     $('.sorry-page-modal').show();
            //
            // }

        });

        $("#insuranceSection").hide();

        // Todo: @here add plan_id, relationship_to_primary_cardholder, plan_type

        $("#have_insurance_no").click(function(){
            $("#insuranceSection").hide();
            // $("#administrator_name, #group_id, #coverage_effective_date, #primary_cardholder, #issuer_id, #insurance_type").removeAttr('required');
        });

        $("#have_insurance_yes").click(function(){
            $("#insuranceSection").show();
            // $("#administrator_name, #group_id, #coverage_effective_date, #primary_cardholder, #issuer_id, #insurance_type").attr('required', true);
        });


    });
    // End Questionnaire


    var input, dtData = [], DT = false;

    function doCreateTable(tableData) {
        var table = document.createElement('table');
        table.setAttribute("id", "search-table");
        table.setAttribute("class", "stripe");
        var tableHead = document.createElement('thead');
        var tableBody = document.createElement('tbody');

        let once = true;

        let row;

        let rel;

        tableData.forEach(function (rowData) {

            let first = true;

            if (once) {
                row = document.createElement('tr');

                rowData.forEach(function (cellData) {
                    var cell = document.createElement('th');
                    cell.appendChild(document.createTextNode(cellData));
                    row.appendChild(cell);
                });

                tableHead.appendChild(row);
                once = false;

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


                        var btn = document.createElement('button');
                        btn.innerHTML = "Covid-19";
                        btn.setAttribute('rel', cellData);
                        btn.setAttribute('name', rowData[1] );
                        rel = cellData;
                        btn.setAttribute('class', 'Covid-19 btn-primary toolb');
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
        decorateAjax(
            $.ajax({
                url: '/biq/find',
                data: 'i=' + inputId + '&q=' + input,
                dataType: 'json',
                success: function (o) {
                    if (!checkAjaxResponse(o))
                        return;

                    data = o.data;

                    let row, xdate_of_birth;

                    dtData = [['', 'Patient Name', 'Date of Birth', 'Patient Email', 'Patient Phone']];

                    data.forEach(function (row) {
                        xdate_of_birth = '1970-01-01';
                        try{
                            xdate_of_birth = row.date_of_birth.$date.replace('T00:00:00.000Z', '');
                        } catch(e){
                            xdate_of_birth = '1970-01-01';
                        }

                        dtData.push([
                            row.id, row.first_name + ' ' + row.last_name,
                            xdate_of_birth,
                            row.email,
                            row.phone_numbers[0].phone_number
                        ]);
                    });

                    if (DT !== false) {
                        DT.destroy(true);
                    }
                    doCreateTable(dtData);
                    DT = $('#search-table').DataTable({
                        'searching': false,
                        'paging': false,
                        'scrollY': 300
                    });
                }
            })
        );
        return false;
    }

    function fetchUser(userId, then=doConfirmPatient){

        preloader_on();
        decorateAjax(
            $.ajax({
                url: '/biq/get',
                data: 'q=' + userId,
                dataType: 'json',
                success: function (o) {
                    if ((checkAjaxResponse(o)) && (typeof then == 'function')){
                        if ((typeof o.data != 'object') || (typeof o.data[0] != 'object'))
                            alert('record not found');
                        else
                            then(o.data[0] || null);
                    }
                }
            })
        );
    }

    $(function () {
        $.noConflict();

        $('.go_home').on('click', function () {
            Modals.showHome();
            $('#barcode-go-home').hide();
            $('#barcode-go-results').hide();
            $('.fvalue').html('');
            if (DT !== false) {
                DT.destroy(true);
            }
        });
        $('.go_search').on('click', function () {
            Modals.show('patient-search-modal');
            $('.fvalue').html('');
            $('#barcode-go-home').hide();
            $('#barcode-go-results').hide();
        });
        $('.go_patient').on('click', function () {
            Modals.show('patient-form-modal');
            $('#barcode-go-home').hide();
            $('#barcode-go-results').hide();
            // Todo: Clear Questionnaire
        });
        $('.go_questionnaire').on('click', function () {
            Modals.show('provider-questionnaire-page-modal');
            $('#barcode-go-home').hide();
            $('#barcode-go-results').hide();
            // Todo: Clear Scanner Page
        });
        $(document.body).on('click', '.seluser', function () {
            preloader_on();
            let id = $(this).attr('rel');

            fetchUser(id);
        });
        $(document.body).on('click', '.seluser-barcode', function () {
            preloader_on();
            let id = $(this).attr('rel');

            fetchUser(id, function(data){
                doConfirmPatient(data);
                doProviderQuestionnaire();
                doScanner();
            });
        });

        $(document.body).on('click', '.Covid-19', function () {
            preloader_on();
            let id = $(this).attr('rel');
            let name = $(this).attr('name');
			window.location.href = "/labResults/covid/"+id+"/"+name;

        });

        $('.provider-search').on('click', function () {
            $('.provider-search-modal').show();
        });
    });

    var insuranceOnce = true;

    function doConfirmPatient(data) {

        // Display review form with Confirm button

        preloader_on();

        Modals.show('patient-form-modal');

        // schedule (encounter_schedule) and site (site_profile) are an array of objects which are joined with the patient

        // Populate the patient confirmation form

        for (const [key, value] of Object.entries(data)) {
            //console.log(key);
            //console.log(value);
            if (key === 'schedule') {
                dateString = value[0].scheduled_time.$date;
                let date = moment(dateString).format('MM/DD/YYYY');
                let time = moment(dateString).format('h:mm a');
                //console.log(date);
                //console.log(time);
                $('#date').html(date);
                $('#time').html(time);

            } else if (key === 'schedule1') {
                //console.log(value);
                let date = value.date;
                let time = value.time;
                let location = value.location;

                $('#schedule2').hide(); // show it later if we have one
                $('#schedule3').hide(); // show it later if we have one

                $('#date').html(date);
                $('#time').html(time);
                $('#location').html(location);

            } else if (key === 'schedule2') {

                //console.log(value);
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


                value.forEach(function (phone) {
                    //console.log(phone);

                    if (phone.phone_type === 0) {

                        // Home

                        $('#hphone').html(formatPhoneNumber(phone.phone_number));

                    } else if (phone.phone_type === 1) {

                        $('#mphone').html(formatPhoneNumber(phone.phone_number));

                    } else {

                        // mobile

                        $('#mphone').html(formatPhoneNumber(phone.phone_number));

                    }


                });


            } else if (key === 'insurances') {

                //console.log('insurances');

                if (insuranceOnce) {

                    insuranceOnce = false; // Only populate the insurance form with the primary insurance

                    for (const [okey, ovalue] of Object.entries(value[0])) {

                        //console.log(`${okey}: ${ovalue}`);

                        if (okey === 'coverage_effective_date') {

                            //console.log(ovalue);
                            dateString = ovalue.$date;
                            let date = moment(dateString).format('MM/DD/YYYY');
                            let time = moment(dateString).format('h:mm a');
                            //console.log(date);
                            //console.log(time);
                            $('#coverage_effective_date').val(date);


                        } else {

                            $('#' + okey).val(ovalue);
                        }

                    }
                }


            } else if (key === 'id') { // Todo: This becomes patient ID after implementing patient-schedule-site-query <-- Not gonna do it
                //console.log(value);
                $('#patient_id').val(value);
                $('#q_patient_id').val(value);

                var strFile = 'https://erik.trackmyvaccine.com/work/i/' + $('#patient_id').val();

                  $.ajax({
                    url: strFile,
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function (q) {
                        //console.log(q);

                        QA = q;

                    }
                });


            } else {

                //console.log(`${key}: ${value}`);
                $('#' + key).html(value);
            }
        }

        // Populate the Questionnaire questions from encounter_schedule

        // Using the raw data right now

        // try {

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

        // if ($("#q1").val() == "No" && $("#q2").val() == "No" && $("#q3").val() == "No" && $("#q4").val() == "No") {
        //     $("#subBtn").removeClass("disabled")
        //     $("#have_insurance_no, #have_insurance_yes, #dosage_number_1, #dosage_number_2. #dosage_number").removeAttr('disabled')
        // } else {
        //     $("#subBtn").addClass("disabled")
        //     $("#have_insurance_no, #have_insurance_yes, #dosage_number_1, #dosage_number_2").attr('disabled', true)
        // }

        if (!insuranceOnce) {
            // iterating once Checks Yes on the private insurance question and opens the thing
            $("#have_insurance_yes").click(function () {

                $("#insuranceSection").show();
                // $("#administrator_name, #group_id, #coverage_effective_date, #primary_cardholder, #issuer_id, #insurance_type").attr('required', true);
            });
            $("#have_insurance_yes").click();

        }

        preloader_off();
    }

    function doProviderQuestionnaire() {

        // populate the questionnaire during the business above

        Modals.show('provider-questionnaire-page-modal');

        return false;

    }

    function doScanner() {

        // console.log('scanner');
        $('#barcode-allergy').hide();

        Modals.show('scanner-page-modal');
        $('#barcode-results').html('');
        $('#barcode-input').val('').focus();
        $('#barcode-form').show();
        $('#barcode-go-home').hide();
        $('#barcode-allergy').hide();

        //console.log(QA);

        if (QA === undefined) {

            QA = {};

            QA.q6 = 'No';
        }

        if (QA.q6 == 'Yes') {

            $('#barcode-allergy').show();

        } else {

            var strFile = '/flags/q6/' + $('#patient_id').val();

            $.ajax({
                url: strFile,
                type: 'GET',
                dataType: 'text', // added data type
                success: function (q) {
                    $('#barcode-allergy').show();

                },
                error: function () {

                    // nothing


                }

            });



        }



        return false;

    }

    function doHandleBarcode() {

        let barcode = $('#barcode-input').val();

        if (barcode.trim() === '') {
            alert('Barcode is required');
            return;
        }

        let adminsite = $('#admin-site').val();
        let patientId = $('#patient_id').val();

        preloader_on();
        decorateAjax(
            $.ajax({
                url: '/biq/barcode',
                data:  {'adminsite': adminsite, 'barcode': barcode, 'patient_id': patientId},
                dataType: 'json',
                success: function (data) {

                    $('#barcode-results').html(data.message);
                    $('#barcode-input').val('').focus();
                    $('#barcode-form').hide();
                    $('#barcode-go-home').show();
                }
            })
        );
    }

    function formatPhoneNumber(phoneNumberString) {
        var cleaned = ('' + phoneNumberString).replace(/\D/g, '')
        var match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/)
        if (match) {
            return '(' + match[1] + ') ' + match[2] + '-' + match[3]
        }
        return null
    }

    function showVaccineLocationSearch(){
        Modals.show('set-vaccine-location-modal');
        vaccineLocationSearchForm.searchInput.focus();
        if ((vaccineLocationSearchForm.searchInput.value == '') && ($('#vaccine-location-search-results').html() == ''))
            doVaccineLocationSearch();
    }

    function doVaccineLocationSearch(){
        var q = vaccineLocationSearchForm.searchInput.value;

        decorateAjax(
            $.ajax('/search-sites',{
                dataType: 'text',
                data: {'q':q},
                beforeSend: function(){
                    preloader_on();
                },
                success: function(data){
                    if (checkAjaxResponse(data))
                        $('#vaccine-location-search-results').html(data);
                }
            })
        );
    }

    function switchVaccineLocation(siteId){
        preloader_on();
        decorateAjax(
            $.ajax({
                type: "GET",
                url:'/switch-site',
                data: {'siteId': siteId, _token: '{{ csrf_token() }}'},
                contentType: 'application/json',
                success: function(data){
                    $('#currentSiteName').html(data.name);
                    $('#vaccine-location-search-results').html('');
                    Modals.showHome();
                }
            })
        );
    }
</script>
