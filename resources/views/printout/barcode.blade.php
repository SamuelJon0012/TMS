@extends('printout.labeller')

@push('pageHeader')
    <link rel="prefetch" href="/barcode/{{$barcode}}.svg" />
    <style>
        .page-wrapper{
            display: flex;
            flex:1;
            flex-direction: column;
            padding: 1pc;
            position: fixed;
            width: 100%;
            height: 100%;
        }

        .page-wrapper img{
            flex:1;
            height:100%;
            width: 100%;
        }

        .barcode-image{
            flex:1; 
            background-image: url('/barcode/{{$barcode}}.svg');
            background-repeat-x: no-repeat;
            background-size: contain;
            margin: 2pc 2pc;
        }
    </style>
@endpush

@section('content')
<div class="printer-page">
    <div class="page-wrapper">
        <div class="barcode-image">
            &nbsp;
        </div>
        <div style="text-align: center; padding-bottom: 1pc;">
        {{$barcode}}
        </div>
    </div>
</div>

<div class="printer-page">
    <div class="page-wrapper" style="top:100%">
        <div class="barcode-image">
            &nbsp;
        </div>
        <div style="text-align: center; padding-bottom: 1pc;">
        {{$barcode}}
        </div>
    </div>
</div>

@endsection