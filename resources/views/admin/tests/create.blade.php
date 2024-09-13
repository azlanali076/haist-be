@extends('admin.layouts.app')
@section('title') Disease Tests @endsection
@section('breadcrumb_1') Disease Tests @endsection
@section('breadcrumb_2') Create @endsection
@section('content')
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('tests.store') }}" method="post">
                @csrf
                <x-forms.input
                    placeholder="Name"
                    label="Name"
                    input-name="name"
                    input-id="name"
                    :errors="$errors->get('name')"
                    :required="true"
                    :value="old('name')"
                />
                <x-forms.input
                    placeholder="Description"
                    label="Description"
                    input-name="description"
                    input-id="description"
                    :errors="$errors->get('description')"
                    :required="false"
                    :value="old('description')"
                />
                <button type="submit" class="btn btn-primary" >Save</button>
            </form>
        </div>
    </div>
@endsection
