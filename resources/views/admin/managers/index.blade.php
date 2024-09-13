@extends('admin.layouts.app')
@section('title') Managers @endsection
@section('breadcrumb_1') Managers @endsection
@section('breadcrumb_2') All @endsection
@section('content')

    <div class="card">
        <div class="card-body">
            <a href="{{ route('managers.create') }}" class="btn btn-primary mb-3" >Create New</a>
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
                    @foreach($managers as $manager)
                        <tr>
                            <td>{{ $manager->facility->name }}</td>
                            <td>{{ $manager->full_name }}</td>
                            <td><a target="_blank" href="mailto:{{ $manager->email }}">{{ $manager->email }}</a></td>
                            <td><a target="_blank" href="tel:{{ $manager->phone }}">{{ $manager->phone }}</a></td>
                            <td>
                                <a href="{{ route('managers.edit',$manager->id) }}" class="btn btn-sm btn-primary" ><i class="fa fa-edit" ></i></a>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteConf('{{route('managers.destroy',$manager->id)}}')" ><i class="fa fa-trash" ></i></button>
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
