@extends('layouts.app')

@section('content')
    <div class="container" id="testResult">
        <div class="row">
            <div class="col-12">

                <p class="my-status center" >
                    <b>Outstanding Patient Tests</b>
                </p>
                <p class="my-status center" >
                    Please select the patient's test that you want to set the result for
                </p>
                <p class="my-status" >
                    Patient Name: {{ $result['name'] }}
                </p>
                <table class="w-100">
                    <thead>
                        <tr>
                            <th>Test #</th>
                            <th>Test Date</th>
                            <th class="w-50">Test Type</th>
                            <th>Result</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                   <?php
                   if(count($result['procedures'])>0)
                   {
                   for( $i=0; $i < count($result['procedures']); $i++ ) {

                   ?>
 						
                        <tr>

                            <td>{{$i+1}}</td>
                            <td>{{ date("m/d/Y",strtotime($result['procedures'][$i]['datetime'])) 	}}</td>
                            <td>{{$result['procedures'][$i]['procedure']->description}}</td>
                            <td>
                            <form action="" method="post">
                            <select required name="result">
                            	<option value=""></option>
                            	<option value="positive">Positive</option>
                            	<option value="negative">Negative</option>
                            	<option value="inconclusive">Inconclusive</option>

                            </select>
                            <input type="hidden" name="procedure_id" value="{{$result['procedures'][$i]['procedure']->id}}">
                            <input type="hidden" name="encounter_id" value="{{$result['procedures'][$i]['encounter_id']}}">
                            <input type="hidden" name="patient_id" value="{{$result['procedures'][$i]['patient_id']}}">
                            {{ csrf_field() }}
                            <input type="submit" class="btn-primary" style="margin-left:70px;" value="Save" >
                            </form>
                            </td>

                        </tr>
                         
                    <?php }
                   }
                   else
                   {
                       ?>
                       <tr>
                       		<td colspan="5">No applicable Lab Tests were found</td>
                   		</tr>
                       <?php
                   }?>
                    </tbody>
                </table>
            </div>
        </div>
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

    .center { text-align: center; }


@endsection