<!-- This is the provider stuff but I kep it here to modify for patient stuff when I get to it -->

<script type="text/javascript">
// Todo: move this to custom.js where it can be CND'd
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
function preloader_on() {

    $('#preloader').show();

}
function preloader_off() {

    $('#preloader').hide();

}
// Todo: only include this if Provider

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

    $('.patient-form-modal').show();

    // schedule (encounter_schedule) and site (site_profile) are an array of objects which are joined with the patient


    for (const [key, value] of Object.entries(data)) {
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
        } else {

            //console.log(`${key}: ${value}`);
            $('#' + key).html(value);
        }
    }

    // Todo: Break out the hphone and mphone if present

    // todo set patient_id hidden field value to data.id

    preloader_off();
}
</script>
