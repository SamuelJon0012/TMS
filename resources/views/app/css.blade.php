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
