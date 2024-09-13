@extends('admin.layouts.app')
@section('title')
Dashboard
@endsection
@section('breadcrumb_1')
Dashboard
@endsection
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow mt-3">
            <div class="card-body">
                <h3 class="text-center">Clinical Manager Dashboard</h3>
                <div class="">
                    <h4>Symptoms</h4>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>S no#</th>
                            <th>Resident Name</th>
                            <th>Symptom Name</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($symptoms_two as $key => $val)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{getPatientName($val['assessment_id'])}}</td>
                                <td>{{getSymptomName($val['symptom_id'])}}</td>
                                <td>{{\Carbon\Carbon::parse($val['created_at'])->format('Y-m-d')}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">
                    <h4>Assessments</h4>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>S no#</th>
                            <th>Resident Name</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($assessments_two as $key => $val)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{getPatientName($val['id'])}}</td>
                                <td>{{\Carbon\Carbon::parse($val['created_at'])->format('Y-m-d')}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">
                    <h4>Confirmed Diagnosis</h4>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>S no#</th>
                            <th>Resident Info</th>
                            <th>Diagnose Name</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($confirmed_diagnosis as $key => $val)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{getPatientName($val['id'])}}</td>
                                <td>{{getDiagnoseName($val['diagnose_id'])}}</td>
                                <td>{{$val['status']}}</td>
                                <td>{{\Carbon\Carbon::parse($val['created_at'])->format('Y-m-d')}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="sidebar p-4 bg-white mt-3">
            <div class="d-block mb-3">
                <a
                    href="{{ route('home',['ranking_by' => request()->ranking_by ?? "symptoms",'date_range' => 'today']) }}">Today</a>
                |
                <a
                    href="{{ route('home',['ranking_by' => request()->ranking_by ?? "symptoms",'date_range' => 'yesterday']) }}">Yesterday</a>
                |
                <a href="{{ route('home',['ranking_by' => request()->ranking_by ?? "symptoms",'date_range' => 'week']) }}">7
                    Days</a>
                |
                <a href="{{ route('home',['ranking_by' => request()->ranking_by ?? "symptoms",'date_range' => 'month']) }}">30
                    Days</a>
            </div>
            <h4 class="text-center mb-3" >Stats By {{ config('constants.date_range.'.(request()->date_range ?? 'month')) }}</h4>
            <div class="row mb-3 results-area">
                <div class="col-md-4">
                    <div class="result-box">
                        <h5>Symptoms <br/><span class="num">{{$stats['symptoms']}}</span></h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="result-box">
                        <h5>Assessments<br/><span class="num">{{$stats['assessments']}}</span></h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="result-box">
                        <h5>Outbreaks <br/><span class="num">{{$stats['outbreaks']}}</span></h5>
                    </div>
                </div>
            </div>
{{--            <div class="button-group">--}}
{{--                <div class="alert-box">--}}
{{--                    <button type="button" class="btn btn-primary position-relative ">--}}
{{--                        Alert--}}
{{--                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">--}}
{{--                            7+--}}
{{--                        </span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
            @php
                $dateFrom = null;
                switch (request()->date_range) {
                    case 'week':
                        $dateFrom = now()->subWeeks()->format('Y-m-d');
                        break;
                    case 'today':
                        $dateFrom = now()->format('Y-m-d');
                        break;
                    case 'yesterday':
                        $dateFrom = now()->subDays()->format('Y-m-d');
                        break;
                    default:
                        $dateFrom = now()->subMonths()->format('Y-m-d');
                }
            @endphp
            <ul class="list p-0 m-0 list-unstyled mt-3">
                <li class="py-2 mb-2 border-bottom"><a class="fs-5" href="{{ route('assessments.index',['status' => 'Pending']) }}">Pending Diagnosis: {{ $stats['pending_diagnosis'] }}</a></li>
                <li class="py-2 mb-2 border-bottom"><a class="fs-5" href="{{ route('assessment-tests.index',['status' => 'Pending','date_from' => $dateFrom]) }}">Pending Results: {{ $stats['pending_results'] }}</a></li>
{{--                <li class="py-2 mb-2 border-bottom"><a class="fs-5" href="#">RN Reports</a></li>--}}
            </ul>
        </div>
    </div>
</div>
@endsection
