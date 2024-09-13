@php
/** @var \App\Models\User[] $admins */
@endphp
@extends('admin.layouts.app')
@section('title') Admins @endsection
@section('breadcrumb_1') Admins @endsection
@section('breadcrumb_2') All @endsection
@section('content')

    <div class="card">
        <div class="card-body">
            <a href="{{ route('admins.create') }}" class="btn btn-primary mb-3" >Create New</a>
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center w-100">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Verified</th>
                        <th>Phone</th>
                        <th>Package</th>
                        <th>Facility</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($admins as $admin)
                        <tr>
                            <td>{{ $admin->full_name }}</td>
                            <td><a target="_blank" href="mailto:{{ $admin->email }}">{{ $admin->email }}</a></td>
                            <td>{{ $admin->hasVerifiedEmail() ? "Yes" : "No" }}</td>
                            <td><a target="_blank" href="tel:{{ $admin->phone }}">{{ $admin->phone }}</a></td>
                            <td></td>
                            <td>{{ (count($admin->facilitiesIfAdmin()) > 0) ? implode(', ',$admin->facilitiesIfAdmin()->pluck('name')->values()->toArray()) : 'N/A' }}</td>
{{--                            <td>{{$admin->facility ? $admin->facility->name : "N/A"}}</td>--}}
                            <td>
                                <a href="{{ route('admins.edit',$admin->id) }}" class="btn btn-sm btn-primary" ><i class="fa fa-edit" ></i></a>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteConf('{{route('admins.destroy',$admin->id)}}')" ><i class="fa fa-trash" ></i></button>
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
            $('table').DataTable({responsive: true});
        }
    </script>
@endsection
