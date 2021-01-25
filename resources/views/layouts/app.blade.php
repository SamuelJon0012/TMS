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

    // Todo: move this to custom.js
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

// Todo: only include this if Provider

function doPatientSearch() {
    input = $('#search-input').val();
    setTimeout(function() {
        $.ajax({
            url: '/biq/find',
            data: 'q=' + input,
            dataType: 'json',
            success: function(o) {

                // Todo: Check for an error object (success = false) or unexpected data

                data = o.data;

                let row, btn;

                dtData = [['','fname', 'lname']] ;

                data.forEach(function(row) {

                    dtData[dtData.length] =
                        [
                            row.id, row.first_name, row.last_name
                        ];
                });

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
                console.log(DT);

            },
            error: function() {
                // Todo: handle this more elegantly
                alert('An error has occurred');

            },

        });
    },100);
    return false;
}
setTimeout(function() {
    $.noConflict();
    $(document.body).on('click', '.seluser' ,function(){
       let rel = $(this).attr('rel');
       console.log(rel);
    });
}, 4000);
</script>
<style>
    body, html {
        height: 100%;
    }
    .search-modal {
        /*display: none;*/
        width: 100%;
        height:90%;
        position: fixed;
        margin-top: 85px;
        top: 0; left: 0;
        background-color: #fff;
        overflow:scroll;
        padding:22px;

    }
    .search-modal-inner {

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
</style>
<div class="search-modal">

    <div class="search-modal-inner">

        <form name="search-form" onsubmit="return doPatientSearch();">

            <input id="search-input" type="search" class="form-control" name="search-input" placeholder="{{ __('Search by name, Email or phone number') }}" >

            <div id="search-results"></div>

        </form>



    </div>

</div>

</body>
</html>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
