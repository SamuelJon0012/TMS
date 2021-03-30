@extends('layouts.app')

@section('content')
    <div class="container" id="testResult">
        <div class="row">
            <div class="col-12">
                <h1>My Lab Results</h1>
                <p class="offset-1 my-status">
                   	@if(!isset($result['status']))
                        <b>My Recent Status: CLEARED as of 00/00/0000</b>
                    @endif
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
                    	@foreach ($result as $res)
                        	@if(isset($res['status']))
                        		<tr>
                        			<td colspan="5">{{$result['msg']}}</td>
                        		</tr>
                            @else
                                <tr>
                                    <td>1</td>
                                    <td>{{$res['date_time']}}</td>
                                    <td>{{$res['description']}}</td>
                                    <td>{{$res['result']}}</td>
                                    <td>{{$res['expiration_date']}}</td>
                                </tr>
                            @endif
                    	@endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(!isset($result['status']))
        <div class="test-result-image">
        
            @if($result[0]['result'] == 'positive')
                <img src="{{ asset("images/positive.png") }}">
            @elseif($result[0]['result'] == 'negative')
            	<img src="{{ asset("images/negative.png") }}">
            @endif
            
        </div>
	@endif
@endsection

@if(!isset($result['status']) && $result[0]['result'] == 'negative')

@section('styleCss')
    #testResult .my-status {
        font-size: 20px;
    }

    .test-result-image {
        display: flex;
        flex-direction: row;
        justify-content: center;
    }
    #app {
        height: 100%;
        background-color: #ffa2a2;
    }
@endsection

@elseif(!isset($result['status']) && $result[0]['result'] == 'positive')

@section('styleCss')
    #testResult .my-status {
        font-size: 20px;
    }

    .test-result-image {
        display: flex;
        flex-direction: row;
        justify-content: center;
    }

    #app {
        height: 100%;
        background-color: #bbf7cf;
    }
@endsection

@endif
