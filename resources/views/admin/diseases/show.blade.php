@extends('admin.layouts.app')
@section('title') Diseases @endsection
@section('breadcrumb_1') Diseases @endsection
@section('breadcrumb_2') View @endsection
@section('content')
    <style>
        hr {
            border-top: 1px solid #cccccc;
        }
    </style>
    <div class="card">
        <div class="card-body">
            <h3>Summary</h3>
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center w-100" >
                    <tbody>
                    <tr>
                        <th>Name</th>
                        <td>{{$diagnose->name}}</td>
                        <th># of Conditions</th>
                        <td>{{count($diagnose->diagnoseConditions)}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <h3>Conditions</h3>
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center w-100">
                    <tbody>
                    @foreach($diagnose->diagnoseConditions as $condition)
                        <tr>
                            <td colspan="6" ><hr></td>
                        </tr>
                        <tr>
                            <th colspan="2">Condition Type</th>
                            <td>{{ucfirst($condition->type)}}</td>
                            <th colspan="2">Compulsory Cases</th>
                            <td>{{$condition->compulsory_cases}}</td>
                        </tr>
                        <tr>
                            <th colspan="2">Check o2 Saturation</th>
                            <td>{{ $condition->check_o2_saturation ? "Yes" : "No" }}</td>
                            <th colspan="2">O2 Saturation Difference Value</th>
                            <td>{{ $condition->o2_saturation_difference_value == 0 ? "N/A" : $condition->o2_saturation_difference_value }}</td>
                        </tr>
                        <tr>
                            <th colspan="6">Cases</th>
                        </tr>
                        @foreach($condition->cases as $case)
                            <tr>
                                <th>Case Type</th>
                                <td>{{ $case->case_type == \App\Models\Symptom::class ? "Symptom" : "Criteria" }}</td>
                                <th>Case Name</th>
                                <td>{{ @$case->case->name }}</td>
                                <th>Must Include</th>
                                <td>{{ $case->must_include ? "Yes" : "No" }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
