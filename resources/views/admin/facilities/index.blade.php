@extends('admin.layouts.app')
@section('title') Facilities @endsection
@section('breadcrumb_1') Facilities @endsection
@section('breadcrumb_2') All @endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('facilities.create') }}" class="btn btn-primary mb-3">Create New</a>
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center w-100">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($facilities as $facility)
                        <tr>
                            <td>{{ $facility->name }}</td>
                            <td><a href="mailto:{{ $facility->email }}">{{ $facility->email }}</a></td>
                            <td><a href="tel:{{ $facility->phone }}">{{ $facility->phone }}</a></td>
                            <td>
                                <a href="{{ route('facilities.edit',$facility->id) }}" class="btn btn-sm btn-primary" ><i class="fa fa-edit" ></i></a>
                                <button onclick="deleteConf('{{ route('facilities.destroy',$facility->id) }}')" class="btn btn-sm btn-danger" ><i class="fa fa-trash" ></i></button>
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
            $('table').DataTable({responsive:true});
        }
    </script>
@endsection
