@extends('admin.layouts.app')
@section('title') Assessment Tests @endsection
@section('breadcrumb_1') Assessment Tests @endsection
@section('breadcrumb_2') All @endsection
@section('content')
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center w-100">
                    <thead>
                    <tr>
                        <th>Assessment ID</th>
                        <th>Resident Name</th>
                        <th>Doctor Name</th>
                        <th>Test Name</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tests as $test)
                        <tr>
                            <td>{{ $test->assessment_id }}</td>
                            <td>{{ $test->assessment->patient->full_name }}</td>
                            <td>{{ $test->assessment->patient->doctor->full_name }}</td>
                            <td>{{ $test->test->name }}</td>
                            <td>
                                <h5><span @class(['badge','badge-xl','badge-soft-primary' => $test->status === 'Pending','badge-soft-success' => $test->status === 'Completed']) >
                                    {{ $test->status }}
                                </span></h5>
                            </td>
                            <td>{{ $test->created_at->format('m/d/Y') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$tests->appends(request()->all())->links()}}
            </div>
        </div>
    </div>
    <div id="modals_container"></div>
@endsection
@section('script')
    <script>
    </script>
@endsection
