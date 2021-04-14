@extends('layouts.app')

@section('content')
    <div class="container" id="covidResult">
        <div class="row">
            <div class="col-12">
                <div id="search-results">
                    @if(!$results)
                        <h3 class="text-danger text-center">{{ __('This user has not taken any tests') }}</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('patientJs')
    @if($results)
        <script>
            function doCreateTable(tableData) {
                var table = document.createElement('table');
                table.setAttribute("id", "search-table");
                table.setAttribute("class", "table table-striped table-hover stripe mb-2 ");
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
                            cell.appendChild(document.createTextNode(cellData));
                            row.appendChild(cell);
                        });
                        tableBody.appendChild(row);
                    }
                });

                table.appendChild(tableHead);
                table.appendChild(tableBody);
                $("#search-results").html('');
                document.getElementById("search-results").appendChild(table);
                $("#search-results").append('<button type="button" class="btn btn-primary mr-2" onclick="exportResults()">{{ __("Export") }}</button><form id="resultExportForm" action="{{ route('resultsPdf') }}" method="post">@csrf</form>');
                $("#search-results").append("<button type='button' class='btn btn-primary' onclick='exportPdf()'>{{ __("Result PDF") }}</button>");

            }

            function doPatientSearch(o) {
                if (!checkAjaxResponse(o))
                    return;

                data = o.data;

                dtData = [['Test Date', 'Test Type', 'Result', 'Result Date & Time', 'Result Corrected']];

                data.forEach(function (row) {
                    dtData.push([
                        row.date,
                        row.type,
                        row.result,
                        row.resultDate,
                        row.resultCorrected
                    ]);
                });

                doCreateTable(dtData);
            }

            function exportResults() {
                $('#resultExportForm').submit();
            }

            function exportPdf() {
                console.log("exportPdf");
            }
        </script>
    @endif
@endsection
@section('scriptJs')
    @if($results)
        let tableData = JSON.parse('{!! $results->content() !!}');
        $(function() {
            doPatientSearch(tableData);
        })
    @endif
@endsection
@section('styleCss')
    #resultExportForm {
        display: none;
    }
@endsection
