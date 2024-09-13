@extends('admin.layouts.app')
@section('title') Disease Tests @endsection
@section('breadcrumb_1') Disease Tests @endsection
@section('breadcrumb_2') Edit @endsection
@section('content')
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('tests.update',[$test->id]) }}" method="post">
                @csrf
                @method('PUT')
                <x-forms.input
                    placeholder="Name"
                    label="Name"
                    input-name="name"
                    input-id="name"
                    :errors="$errors->get('name')"
                    :required="true"
                    :value="old('name',$test->name)"
                />
                <x-forms.input
                    placeholder="Description"
                    label="Description"
                    input-name="description"
                    input-id="description"
                    :errors="$errors->get('description')"
                    :required="false"
                    :value="old('description',$test->description)"
                />
                <button type="submit" class="btn btn-primary" >Save</button>
            </form>
        </div>
    </div>
@endsection
