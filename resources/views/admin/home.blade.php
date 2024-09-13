@extends('admin.layouts.app')
@section('title')
Dashboard
@endsection
@section('breadcrumb_1')
Dashboard
@endsection
@section('content')
@if(auth()->user()->role->name === config('constants.roles.admin'))
    <d class="d-block">
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
    </d>
    <d class="d-block">
        <a href="{{ route('home',['ranking_by' => 'symptoms','date_range' => request()->date_range ?? "month"]) }}">Symptoms</a>
        |
        <a href="{{ route('home',['ranking_by' => 'assessments','date_range' => request()->date_range ?? "month"]) }}">Assessments</a>
        |
        <a href="{{ route('home',['ranking_by' => 'diagnoses','date_range' => request()->date_range ?? "month"]) }}">Diagnoses</a>
        |
        <a href="{{ route('home',['ranking_by' => 'response_time','date_range' => request()->date_range ?? "month"]) }}">Response Time</a>
    </d>
<div class="row mt-3">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="text-center">Facility Ranking By <span class="text-primary" >{{ config('constants.date_range.'.(request()->date_range ?? "month")) }}</span> Group by <span class="text-primary">{{ config('constants.ranking_by.'.(request()->ranking_by ?? "symptoms")) }}</span></h3>
                <div class="table-responsive">
                    <table class="table table-striped table-hover text-center w-100">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Facility Name</th>
                                @if(request()->ranking_by === 'symptoms' || !request()->ranking_by)
                                <th>Total Symptoms</th>
                                @elseif(request()->ranking_by === 'assessments')
                                <th>Total Assessments</th>
                                @elseif(request()->ranking_by === 'diagnoses')
                                <th>Total Diagnoses</th>
                                @elseif(request()->ranking_by === 'response_time')
                                <th>Response Time</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @php
                        $responseTimes = 0;
                        @endphp
                            @foreach($facilities as $k=>$facility)
                            <tr>
                                <td>{{$k+1}}</td>
                                <td>{{ $facility->name }}</td>
                                @if(request()->ranking_by === 'symptoms' || !request()->ranking_by)
                                <th>{{$facility->total_symptoms}}</th>
                                @elseif(request()->ranking_by === 'assessments')
                                <th>{{ $facility->total_assessments }}</th>
                                @elseif(request()->ranking_by === 'diagnoses')
                                <th>{{ $facility->total_diagnoses }}</th>
                                @elseif(request()->ranking_by === 'response_time')
                                <th>{{ calculateHoursFromSeconds($facility->avg_response_time) }}.{{ calculateMinutesFromSeconds($facility->avg_response_time) }} Hours</th>
                                @endif
                            </tr>
                                @php
                                    $responseTimes += $facility->avg_response_time;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                    <div class="response-time d-flex flex-column  justify-content-center">
                        <h4>Average Response Time All Facility: <strong  >{{ calculateHoursFromSeconds($responseTimes).'.'.calculateMinutesFromSeconds($responseTimes) }} Hours</strong></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body">
                <ul class="list p-0 m-0 list-unstyled">
                    <li class="py-2 mb-2 border-bottom">
                        <a class="fs-5" href="#">Total Symptoms: {{$total_symptoms}}</a>
                    </li>
                    <li class="py-2 mb-2 border-bottom">
                        <a class="fs-5" href="#">Total Assessments: {{$total_assessments}}</a>
                    </li>
                    <li class="py-2 mb-2 border-bottom">
                        <a class="fs-5" href="#">Total Diagnoses: {{$total_diseases}}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
