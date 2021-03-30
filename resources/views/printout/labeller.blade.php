<!doctype html>
<html >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="viewport" content="width=device-width, user-scalable=no">

        <style>
            *, ::after, ::before {
                box-sizing: border-box;
            }
            @media print {
                * {
                    -webkit-print-color-adjust: exact !important; /*Chrome, Safari */
                    color-adjust: exact !important;  /*Firefox*/
                }
                .printer-page{
                    page-break-after: always;
                }
            }
            body{
                font-size: 3vw;
            }
        </style>
        <style type="text/css" media="print">
            @page{
                size: auto;
                margin: 0;
            }
        </style>

        @stack('pageHeader')
    </head>
    <body>
        @yield('content')
        @stack('pageBottom')

        <script>
            window.addEventListener('load',function(){
                window.print();
            });
        </script>
    </body>
</html>