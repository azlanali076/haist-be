@extends('admin.layouts.app')
@section('title') Symptoms @endsection
@section('breadcrumb_1') Symptoms @endsection
@section('breadcrumb_2') All @endsection
@section('content')

    <div class="card">
        <div class="card-body">
            <button type="button" onclick="addModal()" class="btn btn-primary" >Create New</button>
            <div class="table-responsive mt-3">
                <table class="table table-striped table-hover text-center w-100">
                    <thead>
                    <tr>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($symptoms as $symptom)
                        <tr>
                            <td>{{ @$symptom->category->name }}</td>
                            <td>{{ $symptom->name }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" onclick="editModal({{ $symptom->id }})" ><i class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteConf('{{ route('symptoms.destroy',[$symptom->id]) }}')" ><i class="fa fa-trash"></i></button>
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
            $.get('{{ route('symptoms.create') }}',{},function(e){
                $('.conf').html(e);
                openModal('create_symptom_modal');
            });
        }

        function editModal(id){
            $.get(`{{ route('symptoms.index') }}/${id}/edit`,{},function(e){
                $('.conf').html(e);
                openModal('edit_symptom_modal');
            });
        }

        window.onload = function(){
            $("table").DataTable({
                responsive: true
            });
        }
    </script>
@endsection
