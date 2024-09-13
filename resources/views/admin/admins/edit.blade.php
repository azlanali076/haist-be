@extends('admin.layouts.app')
@section('title') Create Admin @endsection
@section('breadcrumb_1') Admins @endsection
@section('breadcrumb_2') Create @endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admins.update',$admin->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    @foreach($fields as $field)
                        <div class="col-lg-6">
                            @if($field and isset($field['name']))
                                @php
                                $fieldName = $field['name'];
                                @endphp
                                <x-forms.input :input-name="$field['name']" :input-id="$field['id']" :type="$field['type']"
                                               :label="$field['label']" :placeholder="$field['placeholder']" :value="old($field['name'],$admin->$fieldName)"
                                               :errors="$errors->get($field['name'])" :required="$field['required']" :options="$field['options']"
                                />
                            @endif
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-success" >Save</button>
            </form>
        </div>
    </div>
@endsection
