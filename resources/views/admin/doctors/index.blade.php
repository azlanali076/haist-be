@php
/** @var \App\Models\User[] $doctors */
@endphp
@extends('admin.layouts.app')
@section('title') Doctors @endsection
@section('breadcrumb_1') Doctors @endsection
@section('breadcrumb_2') All @endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('doctors.create') }}" class="btn btn-primary" >Add New</a>
            <div class="table-responsive mt-3">
                <table class="table table-striped table-hover text-center w-100">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Verified</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($doctors as $doctor)
                        <tr>
                            <td>{{ $doctor->fulL_name }}</td>
                            <td>{{ $doctor->email }}</td>
                            <td>{{ $doctor->hasVerifiedEmail() ? "Yes" : "No" }}</td>
                            <td>
                                <a href="{{ route('doctors.edit',$doctor->id) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-title="Edit" ><i class="fa fa-edit" ></i></a>
                                <a href="javascript:void(0)" onclick="deleteConf('{{ route('doctors.destroy',$doctor->id) }}')" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-title="Delete" ><i class="fa fa-trash" ></i></a>
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
            $('table').DataTable();
        }
    </script>
@endsection
