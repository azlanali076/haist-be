@extends('admin.layouts.app')
@section('title') Categories @endsection
@section('breadcrumb_1') Categories @endsection
@section('breadcrumb_2') All @endsection
@section('content')

    <div class="card">
        <div class="card-body">
            <button type="button" onclick="addModal()" class="btn btn-primary" >Create New</button>
            <div class="table-responsive mt-3">
                <table class="table table-striped table-hover text-center w-100">
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>Name</th>
                        <th>No. of Symptoms</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->category_type }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ count($category->symptoms) }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" onclick="editModal({{ $category->id }})" ><i class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteConf('{{ route('categories.destroy',[$category->id]) }}')" ><i class="fa fa-trash"></i></button>
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

        function addModal(){
            $.get('{{ route('categories.create') }}',{},function(e){
                $('.conf').html(e);
                openModal('create_category_modal');
            });
        }

        function editModal(id){
            $.get(`{{ route('categories.index') }}/${id}/edit`,{},function(e){
                $('.conf').html(e);
                openModal('edit_category_modal');
            });
        }

        window.onload = function(){
            $("table").DataTable({
                responsive: true
            });
        }
    </script>
@endsection
