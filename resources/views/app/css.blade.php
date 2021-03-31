<style>
    body, html {
        height: 100%;
    }

    .page-modal-inner {
        padding: 0 5% 0 5%;
    }

    .search-modal, .patient-form-modal, .modals {
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
    .search-modal-inner, .patient-form-modal-inner, modals-inner {

        margin-left: auto;
        margin-right: auto;
        width: 100%;
        max-width: 1200px;
        min-height:500px;
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
        margin: 10px;
        padding: 10px;
        /*width: 300px;*/

    }
    .patient-show th {
        text-align: right;
        padding-right: 6px;
        /*max-width: 300px;*/

    }
    .patient-show td {
        text-align: left;
        padding-left: 6px;
        overflow: hidden;
        /*max-width: 300px;*/

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

    /* Questionnaires */

    .Qoption{
        cursor:pointer;
    }
    .GreenSelect
    {
        background:green;
    }
    .RedSelect
    {
        background:red;
    }
    .GreySelect
    {
        background:grey;
    }
    .sorry-page-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow:scroll;
        text-align: center;
    }
    .sorry-modal-inner {
        border: 1px solid black;
        width: 100%;
        opacity: 1;
        border-radius: 12px;
        max-width: 800px;
        margin-left: auto;
        margin-right:auto;
        margin-top: 22px;
        overflow: hidden;
        background-color: #827F7D;
        text-align: center;
        min-height: 550px;
    }

    .sorry-top {
        background-color: #174797;
        color: white;
        font-size: 28px

    }
    .sorry-feel {
        color:black;
        background-color: #B3C6E7;
        font-size: 18px
    }
    .sorry-main {
        color: white;
        background-color: #827F7D;
        padding: 12px;
    }
    .sorry-col-1, .sorry-col-2, .sorry-col-3 {
        width: 33%;
        padding: 12px;

    }
    .sorry-circle-1, .sorry-circle-2, .sorry-circle-3 {
        width: 100px;
        line-height: 100px;
        border-radius: 50%;
        text-align: center;
        font-size: 32px;
        border: 2px solid #666;
        background-color: #17479B;
        color: white;
        margin-left: auto;
        margin-right: auto;

    }
    .sorry-square-1, .sorry-square-2, .sorry-square-3 {
        margin-top: 15px;
        padding: 12px;
        background-color: #B3C6E7;
        text-align: left;
        height: 170px;
        color: black;

    }
    .toolb {

        margin: 3px 8px 0 0;
    }
    #patient-data .card {
        min-height: 360px;
    }
    #barcode-allergy {
        border: 1px solid #000;
        background-color: #ff9966;
        color: black;
        padding: 10px;
        width: 160px;
    }

    .help-title {
        text-align: center;
        color: #0a83c1;
    }

    #viewer-div {
        max-width: 1000px;
        margin: 0 auto;
        -webkit-box-shadow: 0px 0px 10px 2px rgb(0 0 0 / 46%);
        box-shadow: 0px 0px 10px 2px rgb(0 0 0 / 46%);
        border-radius: 8px;
        padding: 20px;
        text-align: center;
    }

    #viewer-div > h3 {
        margin-bottom: 30px;
    }

    #viewer-div > p {
        margin-bottom: 3px;
    }
</style>
