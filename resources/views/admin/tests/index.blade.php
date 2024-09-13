@extends('admin.layouts.app')
@section('title') Disease Tests @endsection
@section('breadcrumb_1') Disease Tests @endsection
@section('breadcrumb_2') All @endsection
@section('content')
    <div class="card shadow">
        <div class="card-body">
            <a href="{{ route('tests.create') }}" class="btn btn-primary mb-3" >Create New</a>
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center w-100">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tests as $test)
                        <tr>
                            <td>{{ $test->name }}</td>
                            <td>{{ $test->description }}</td>
                            <td>
                                <a href="{{ route('tests.edit',$test->id) }}" class="btn btn-sm btn-primary" ><i class="fa fa-edit" ></i></a>
                                <a href="javascript:void(0)" onclick="deleteConf('{{route('tests.destroy',$test->id)}}')" class="btn btn-sm btn-danger" ><i class="fa fa-trash" ></i></a>
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
            $("table").DataTable();
        }
    </script>
@endsection
