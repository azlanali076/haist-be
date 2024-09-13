@extends('admin.layouts.app')
@section('title') Doctors @endsection
@section('breadcrumb_1') Doctors @endsection
@section('breadcrumb_2') Edit @endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('doctors.update',$doctor->id) }}" method="post">
                @csrf
                @method('PUT')
                @foreach($fields as $field)
                    @php
                        $fieldName = $field['name'];
                    @endphp
                    <x-forms.input :input-name="$field['name']" :input-id="$field['id']" :placeholder="$field['placeholder']"
                                   :label="$field['label']" :type="$field['type'] ?? 'text'" :value="old($field['name'],$doctor->$fieldName)" :errors="$errors->get($field['name'])"
                                   :required="$field['required']"
                    />
                @endforeach

                <button type="submit" class="btn btn-success" >Save</button>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        window.onload = function(){
        }
    </script>
@endsection
