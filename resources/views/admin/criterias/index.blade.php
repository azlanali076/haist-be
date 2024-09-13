@extends('admin.layouts.app')
@section('title') Criterias @endsection
@section('breadcrumb_1') Criterias @endsection
@section('breadcrumb_2') All @endsection
@section('content')

    <div class="card">
        <div class="card-body">
            <a href="{{ route('criteria.create') }}" class="btn btn-primary" >Create New</a>
            <div class="table-responsive mt-3">
                <table class="table table-striped table-hover text-center w-100">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Criteria Key</th>
                        <th>Criteria Operator</th>
                        <th>Criteria Value</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($criterias as $criteria)
                        <tr>
                            <td>{{ $criteria->name }}</td>
                            <td>{{ $criteria->criteria_key }}</td>
                            <td>{{ $criteria->criteria_comparison_operator }}</td>
                            <td>{{ $criteria->criteria_value }}</td>
                            <td>
                                <a href="{{ route('criteria.edit',$criteria->id) }}" class="btn btn-primary btn-sm" ><i class="fa fa-edit" ></i></a>
                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteConf('{{route('criteria.destroy',$criteria->id)}}')" ><i class="fa fa-trash" ></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        window.onload = function(){
            $("table").DataTable({
                responsive: true
            });
        }
    </script>
@endsection
