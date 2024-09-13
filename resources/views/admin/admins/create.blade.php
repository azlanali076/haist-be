@extends('admin.layouts.app')
@section('title') Create Admin @endsection
@section('breadcrumb_1') Admins @endsection
@section('breadcrumb_2') Create @endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admins.store') }}" method="post">
                @csrf
                <div class="row">
                    @foreach($fields as $field)
                        <div class="col-lg-6">
                            <x-forms.input :input-name="$field['name']" :input-id="$field['id']" :type="$field['type']"
                                           :label="$field['label']" :placeholder="$field['placeholder']" :value="old($field['name'])"
                                           :errors="$errors->get($field['name'])" :required="$field['required']" :options="$field['options']"
                            />
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-success" >Save</button>
            </form>
        </div>
    </div>
@endsection
