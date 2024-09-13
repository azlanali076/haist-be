@extends('admin.layouts.app')
@section('title') Residents @endsection
@section('breadcrumb_1') Residents @endsection
@section('breadcrumb_2') All @endsection
@section('content')
    <div class="card shadow">
        <div class="card-body">
            <a href="{{ route('residents.create') }}" class="btn btn-primary" >Create New</a>
            <div class="table-responsive mt-3">
                <table class="table table-striped table-hover text-center w-100">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Room Number</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Date of Birth</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($residents as $resident)
                        <tr>
                            <td>{{ $resident->id }}</td>
                            <td>{{ $resident->room_number }}</td>
                            <td>{{ $resident->full_name }}</td>
                            <td><a href="mailto:{{ $resident->email }}">{{ $resident->email }}</a></td>
                            <td>{{ $resident->dob->format('m/d/Y') }}</td>
                            <td>
                                <a href="{{ route('residents.edit',$resident->id) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-title="Edit" ><i class="fa fa-edit" ></i></a>
                                <a href="javascript:void(0)" onclick="deleteConf('{{ route('residents.destroy',$resident->id) }}')" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-title="Delete" ><i class="fa fa-trash" ></i></a>
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
