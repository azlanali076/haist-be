@extends('admin.layouts.app')
@section('title') Nurses @endsection
@section('breadcrumb_1') Nurses @endsection
@section('breadcrumb_2') All @endsection
@section('content')

    <div class="card">
        <div class="card-body">
            <a href="{{ route('nurses.create') }}" class="btn btn-primary mb-3" >Create New</a>
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center w-100">
                    <thead>
                    <tr>
                        <th>Facility</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($nurses as $nurse)
                        <tr>
                            <td>{{ $nurse->facility->name }}</td>
                            <td>{{ $nurse->full_name }}</td>
                            <td><a target="_blank" href="mailto:{{ $nurse->email }}">{{ $nurse->email }}</a></td>
                            <td><a target="_blank" href="tel:{{ $nurse->phone }}">{{ $nurse->phone }}</a></td>
                            <td>
                                <a href="{{ route('nurses.edit',$nurse->id) }}" class="btn btn-sm btn-primary" ><i class="fa fa-edit" ></i></a>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteConf('{{route('nurses.destroy',$nurse->id)}}')" ><i class="fa fa-trash" ></i></button>
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
