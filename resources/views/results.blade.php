@extends('layouts.app')

@section('content')
    <div class="container" id="testResult">
        <div class="row">
            <div class="col-12">
                <h1>My Lab Results</h1>
                <p class="offset-1 my-status">
                    <b>My Recent Status: CLEARED as of 00/00/0000</b>
                </p>
                <table class="w-100">
                    <thead>
                        <tr>
                            <th>Test #</th>
                            <th>Test Date</th>
                            <th class="w-50">Test Type</th>
                            <th>Result</th>
                            <th>Expiration Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>00/00/0000</td>
                            <td>Test type</td>
                            <td>Negative</td>
                            <td>00/00/0000 00:00:00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="test-result-image">
        @if($positive)
            <img src="{{ asset("images/positive.png") }}">
        @endif
        @if($negative)
            <img src="{{ asset("images/negative.png") }}">
        @endif
    </div>
@endsection

@section('styleCss')
    #testResult .my-status {
        font-size: 20px;
    }

    .test-result-image {
        display: flex;
        flex-direction: row;
        justify-content: center;
    }

    .positive-page {
        background-color: #bbf7cf;
    }

    .negative-page {
        background-color: #ffa2a2;
    }
@endsection
