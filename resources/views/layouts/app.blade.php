<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/custom.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <style type="text/css">
    @yield('styleCss')
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand small-logo" href="{{ url('/') }}">
			<img src="logo.jpg" style="height:48px;" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                      <li class="nav-item">
                          <a class="nav-link" href="#">{{ __('About Us') }}</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="#">{{ __('Contact Us') }}</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="#">{{ __('Help') }}</a>
                      </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <!--<li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}?rt=patient">{{ __('Patient Register') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}?rt=provider">{{ __('Provider Register') }}</a>
                                </li> --!>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">{{ __('Dashboard') }}</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <style>
        body, html {
            height: 100%;
        }

        .search-modal, .patient-form-modal {
            display: none;
            width: 100%;
            height:90%;
            position: fixed;
            margin-top: 85px;
            top: 0; left: 0;
            background-color: #fff;
            overflow:scroll;
            padding:22px;

        }
        .patient-form-modal {
            display: none;
        }
        .search-modal-inner, .patient-form-modal-inner {

            margin-left: auto;
            margin-right: auto;
            width: 100%;
            max-width: 900px;
            min-height:400px;
            background-color: #fff;
            text-align: center;
        }
        #search-results {
            text-align:left;
            width:100%;
        }
        #search-table {
            width: 100%;
        }
        .patient-show {
            border: 1px solid black;
            border-radius: 10px;
            margin: 10px;
            padding: 10px;
            width: 400px;
        }
        .patient-show th {
            text-align: right;
            padding-right: 6px;
            max-width: 200px;

        }
        .patient-show td {
            text-align: left;
            padding-left: 6px;
            overflow: hidden;
            max-width: 200px;

        }
        .rightside, .leftside {
            float: left;


        }
        #preloader {

            position: fixed;
            top: 0; left:0; bottom: 0; right: 0;
            background-color: rgba(0,0,255,0.1);
            padding-top: 40%;
            text-align: center;
        }
        .breadcrumbs {
            text-align: left;
            font-size: 80%;
            margin-top:-20px;
            padding-bottom: 6px;
        }
        .go_link {
            cursor: pointer;
        }

        .go_link:hover {
            text-decoration: underline;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

<!-- TawkTo::widgetCode('5ffc8653c31c9117cb6d8992') -->
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5ffc8653c31c9117cb6d8992/1erp6pdd8';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<script type="text/javascript">
@yield('scriptJs')

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
                        btn.innerHTML = "X";
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

function doPatientSearch() {
    console.log('doPatientSearch');
    input = $('#search-input').val();
    preloader_on();
    setTimeout(function() {
        $.ajax({
            url: '/biq/find',
            data: 'q=' + input,
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

                console.log('dtData');
                console.log(dtData);

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
                console.log('DT');
                console.log(DT);
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

                console.log('o');
                console.log(o);

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
    })
});


function doConfirmPatient(data) {

    $('.patient-form-modal').show();

    for (const [key, value] of Object.entries(data)) {
        console.log(`${key}: ${value}`);
        $('#' + key).html(value);
    }
    // Todo: Get the encounter_schedule and site_profile as well, break up the date into date and time

    // Todo: Break out the hphone and mphone if present

    // todo set patient_id hidden field value to data.id

    preloader_off();

}
</script>

    <div class="search-modal modals">

        <div class="search-modal-inner">

            <div class="breadcrumbs"><span class="go_home"><- Home</span></div>

            <form name="search-form" onsubmit="return doPatientSearch();">

                <input id="search-input" type="search" class="form-control" name="search-input" placeholder="{{ __('Search by name, Email or phone number') }}" >

            </form>

            <div id="search-results"></div>

        </div>

    </div>
    <div class="patient-form-modal modals">

        <div class="patient-form-modal-inner">

            <div class="breadcrumbs"><span class="go_home go_link"><- Home</span> <span class="go_search go_link"> <- Search</span></div>

            <div id="patient-data">

                <div class="leftside">
                    <table class="patient-show">
                        <tr>
                            <td colspan="2" style="text-align:center;color:blue;">Personal Data</td>
                        </tr>
                        <tr>
                            <th class="flabel">First Name</th>
                            <td class="fvalue" id="first_name"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Last Name</th>
                            <td class="fvalue" id="last_name"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Date of Birth</th>
                            <td class="fvalue" id="date_of_birth"></td>
                        </tr>
                        <tr>
                            <th class="flabel">SSN</th>
                            <td class="fvalue" id="ssn"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Driver's License</th>
                            <td class="fvalue" id="dl_number"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Address Line 1</th>
                            <td class="fvalue" id="address1"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Address Line 2</th>
                            <td class="fvalue" id="address2"></td>
                        </tr>
                        <tr>
                            <th class="flabel">City</th>
                            <td class="fvalue" id="city"></td>
                        </tr>
                        <tr>
                            <th class="flabel">State</th>
                            <td class="fvalue" id="state"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Zipcode</th>
                            <td class="fvalue" id="zipcode"></td>
                        </tr>
                    </table>
                </div>
                <div class="rightside">
                    <table class="patient-show">
                        <tr>
                            <td colspan="2" style="text-align:center;color:blue;">Demographic Data</td>
                        </tr>
                        <tr>
                            <th class="flabel">Email Address</th>
                            <td class="fvalue" id="email"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Mobile Phone Number</th>
                            <td class="fvalue" id="mphone"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Home Phone Number</th>
                            <td class="fvalue" id="hphone"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Birth Sex</th>
                            <td class="fvalue" id="birth_sex"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Race</th>
                            <td class="fvalue" id="race"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Ethnicity</th>
                            <td class="fvalue" id="ethnicity"></td>
                        </tr>
                    </table>

                    <table class="patient-show">
                        <tr>
                            <td colspan="2" style="text-align:center;color:blue;">Vaccine Schedule</td>
                        </tr>
                        <tr>
                            <th class="flabel">Location</th>
                            <td class="fvalue" id="location"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Date</th>
                            <td class="fvalue" id="date"></td>
                        </tr>
                        <tr>
                            <th class="flabel">Time</th>
                            <td class="fvalue" id="time"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div style="clear:both;"></div>
            <form name="patient-form" onsubmit="return doPatientForm();">
                <input type="hidden" value="0" id="patient_id" name="id">
                <input type="submit" value="Confirm Patient" class="btn btn-primary">
            </form>
        </div>
    </div>
    <div id="preloader" style="display:none;">

        <img src="/preloader.gif">

    </div>
</body>
</html>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
