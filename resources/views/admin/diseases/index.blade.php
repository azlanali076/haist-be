@extends('admin.layouts.app')
@section('title') Diseases @endsection
@section('breadcrumb_1') Diseases @endsection
@section('breadcrumb_2') All @endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('diseases.create') }}" class="btn btn-primary mb-3" >Create New</a>
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center w-100">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($diseases as $disease)
                        <tr>
                            <td>{{ $disease->name }}</td>
                            <td>
                                <a href="{{ route('diseases.show',$disease->id) }}" class="btn btn-sm btn-primary" ><i class="fa fa-eye" ></i></a>
{{--                                <a href="{{ route('diseases.edit',$disease->id) }}" class="btn btn-sm btn-primary" ><i class="fa fa-edit" ></i></a>--}}
                                <button onclick="deleteConf('{{ route('diseases.destroy',$disease->id) }}')" class="btn btn-sm btn-danger" ><i class="fa fa-trash" ></i></button>
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
