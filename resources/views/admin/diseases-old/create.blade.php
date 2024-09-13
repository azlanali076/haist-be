@extends('admin.layouts.app')
@section('title') Diseases @endsection
@section('breadcrumb_1') Diseases @endsection
@section('breadcrumb_2') Create @endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('diseases.store') }}" method="post">
                @csrf
                <div class="row">
                    @foreach($fields as $field)
                        <div class="col-lg-6">
                            @if($field and isset($field['name']))
                                <x-forms.input :input-name="$field['name']" :input-id="$field['id']" :type="$field['type']"
                                   :label="$field['label']" :placeholder="$field['placeholder']" :value="old($field['name'])"
                                   :errors="$errors->get($field['name'])" :required="$field['required']" :options="$field['options']"
                                   :multiple="$field['multiple'] ?? false" :step="$field['step'] ?? 1" :number-min="$field['min'] ?? 1"
                                />
                            @endif
                        </div>
                    @endforeach
                </div>
                <div id="symptoms_container">
                    <div data-repeater-list="symptoms">
                        <div class="row mb-3" data-repeater-item >
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Symptoms</label>
                                    <select name="symptom_id" class="form-control">
                                        @foreach($symptoms as $symptom)
                                            <option value="{{$symptom->id}}">{{$symptom->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label># of Times in 24 hours</label>
                                    <input type="number" name="times" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button data-repeater-delete class="btn btn-danger mt-4" type="button" >Delete</button>
                            </div>
                        </div>
                    </div>
                    <button data-repeater-create type="button" class="btn btn-primary" >Add More</button>
                </div>
                <button type="submit" class="btn btn-success mt-3" >Save</button>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        window.onload = function(){
            $("#symptom_ids").select2();
            $("#last_criteria_if_all_fails").select2();
            $("#test_ids").select2();
            $("#must_include_symptom_ids").select2();
            $("#must_include_criteria_ids").select2();
            $("#check_current_saturation").select2();
            $("#criteria_ids").select2();
            $("#symptoms_container").repeater({
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    if(confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
            });
        }
    </script>
@endsection
