@extends('layouts.app')

@section('content')
    <div class="container" id="covidResult">
        <div class="row">
            <div class="col-12">
                <div id="search-results"></div>
            </div>
        </div>
    </div>
@endsection

@section('patientJs')
    <script>
        var DT = false;
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
            table.after("<button type='button'>Test</button>")
            table.after("<button type='button'>Test 1</button>")
            $('#search-results').html('');
                document.getElementById("search-results").appendChild(table);

            $("#search-results").add("<");

        }

        function doPatientSearch(o) {
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
        }
    </script>
@endsection
@section('scriptJs')
    let tableData = JSON.parse('{!! $data->content() !!}');
    $(function() {
        doPatientSearch(tableData);
    })
@endsection
