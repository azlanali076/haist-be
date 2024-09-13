@extends('admin.layouts.app')
@section('title') Residents @endsection
@section('breadcrumb_1') Residents @endsection
@section('breadcrumb_2') Create @endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('residents.store') }}" method="post" enctype="multipart/form-data" >
                @csrf
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <x-forms.input label="First Name" placeholder="Enter First Name" :errors="$errors->get('first_name')"
                           :value="old('first_name')" :required="true" input-name="first_name" input-id="first_name" />
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <x-forms.input label="Last Name" placeholder="Enter Last Name" :errors="$errors->get('last_name')"
                           :value="old('last_name')" :required="true" input-name="last_name" input-id="last_name" />
                    </div>
                </div>
                <x-forms.input label="Email" placeholder="Enter Email" type="email" :errors="$errors->get('email')"
                   :value="old('email')" :required="true" input-name="email" input-id="email" />
                <x-forms.input label="Date of Birth" placeholder="Enter Date of Birth" type="date" :errors="$errors->get('dob')"
                   :value="old('dob')" :required="true" input-name="dob" input-id="dob" />
                <x-forms.input label="Gender" placeholder="Select Gender" type="select" :errors="$errors->get('gender')"
                   :value="old('gender')" :required="true" input-name="gender" input-id="gender"
                   :options="[['label' => 'Male','value' => 'Male'],['label' => 'Female','value' => 'Female'],['label' => 'Others','value' => 'Others']]" />
                <x-forms.input label="Room #" placeholder="Enter Room #" :errors="$errors->get('room_number')"
                   :value="old('room_number')" :required="true" input-name="room_number" input-id="room_number" />
                <x-forms.input label="Doctor" placeholder="Select Doctor" type="select" :errors="$errors->get('doctor_id')"
                   :value="old('doctor_id')" :required="true" input-name="doctor_id" input-id="doctor_id"
                   :options="$doctors->map(fn ($doctor) => ['value' => $doctor->id,'label' => $doctor->full_name_with_verification])->toArray()" />
                <x-forms.input label="Avatar" placeholder="Avatar" :errors="$errors->get('avatar')" type="file" accept="image/*"
                   :value="old('avatar')" :required="false" input-name="avatar" input-id="avatar" />
                <button type="submit" class="btn btn-success" >Save</button>
            </form>
        </div>
    </div>
@endsection
