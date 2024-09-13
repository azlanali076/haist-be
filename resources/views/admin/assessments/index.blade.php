@extends('admin.layouts.app')
@section('title') Assessments @endsection
@section('breadcrumb_1') Assessments @endsection
@section('breadcrumb_2') All @endsection
@section('content')
    <div class="card shadow">
        <div class="card-body">
{{--            <form action="{{ route('assessments.index') }}" method="get">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-3">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="search">Search</label>--}}
{{--                            <input type="search" class="form-control" name="search" id="search" placeholder="Search...">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center w-100">
                    <thead>
                    <tr>
                        <th>Resident Name</th>
                        <th>Doctor Name</th>
                        <th># of Symptoms</th>
                        <th># of Possible Diseases</th>
                        <th># of Ordered Tests</th>
                        <th>Diagnosed Disease</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($assessments as $assessment)
                        <tr>
                            <td>{{ $assessment->patient->full_name }}</td>
                            <td>{{ $assessment->patient->doctor->full_name }}</td>
                            <td>{{ count($assessment->symptoms) }}</td>
                            <td><button type="button" class="btn btn-sm btn-primary" onclick="possibleDiseases({{$assessment->id}})" >View <span class="badge bg-info" >{{ count($assessment->possibleDiseases) }}</span></button></td>
                            <td>{{ count($assessment->tests) }}</td>
                            <td>{{ $assessment->diagnose ? $assessment->diagnose->name : "N/A" }}</td>
                            <td>
                                <h5><span @class(['badge','badge-xl','badge-soft-primary' => $assessment->status === 'Pending','badge-soft-success' => $assessment->status === 'Completed']) >
                                    {{ $assessment->status }}
                                </span></h5>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$assessments->appends(request()->all())->links()}}
            </div>
        </div>
    </div>
    <div id="modals_container"></div>
@endsection
@section('script')
    <script>
        function possibleDiseases(id){
            $.get(`{{url('assessments')}}/${id}/possible-diseases`,{},function(e){
                $("#modals_container").html(e);
                let possibleDiseasesModal = new bootstrap.Modal('#possible_diseases_modal');
                possibleDiseasesModal.show();
                // $("#possible_diseases_modal").modal();
            });
        }
    </script>
@endsection
