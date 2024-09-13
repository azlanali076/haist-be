@extends('admin.layouts.app')
@section('title') Diseases @endsection
@section('breadcrumb_1') Diseases @endsection
@section('breadcrumb_2') Edit @endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('diseases.update',$disease->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    @foreach($fields as $field)
                        <div class="col-lg-6">
                            @if($field and isset($field['name']))
                                @php
                                $fieldName = str_replace("[]","",$field['name']);
                                @endphp
                                <x-forms.input :input-name="$field['name']" :input-id="$field['id']" :type="$field['type']"
                                               :label="$field['label']" :placeholder="$field['placeholder']" :value="old($field['name'],$disease->$fieldName)"
                                               :errors="$errors->get($field['name'])" :required="$field['required']" :options="$field['options']"
                                               :multiple="$field['multiple'] ?? false" :step="$field['step'] ?? 1" :number-min="$field['min'] ?? 1"
                                />
                            @endif
                        </div>
                    @endforeach
                    <div class="col-lg-6">
                        <x-forms.input
                            placeholder="Select Must Include Symptoms"
                            label="Must Include Symptoms"
                            type="select"
                            :options="$symptoms->map(fn ($symptom) => ['label' => $symptom->name,'value' => $symptom->id])->toArray()"
                            :required="false"
                            :value="old('must_include_symptom_ids[]',$disease->must_include_symptom_ids)"
                            input-name="must_include_symptom_ids[]"
                            input-id="must_include_symptom_ids"
                            :errors="$errors->get('must_include_symptom_ids')"
                            :multiple="true"
                        />
                    </div>
                    <div class="col-lg-6">
                        <x-forms.input
                            placeholder="Select Criteria"
                            label="Criteria"
                            type="select"
                            :options="$criterias->map(fn ($criteria) => ['label' => $criteria->name,'value' => $criteria->id])->toArray()"
                            :required="false"
                            :value="old('criteria_ids[]',$disease->criteria_ids)"
                            input-name="criteria_ids[]"
                            input-id="criteria_ids"
                            :errors="$errors->get('criteria_ids')"
                            :multiple="true"
                        />
                    </div>
                    <div class="col-lg-6">
                        <x-forms.input
                            placeholder="Select Must Include Criteria"
                            label="Must Include Criteria"
                            type="select"
                            :options="$criterias->map(fn ($criteria) => ['label' => $criteria->name,'value' => $criteria->id])->toArray()"
                            :required="false"
                            :value="old('must_include_criteria_ids[]',$disease->must_include_criteria_ids)"
                            input-name="must_include_criteria_ids[]"
                            input-id="must_include_criteria_ids"
                            :errors="$errors->get('must_include_criteria_ids')"
                            :multiple="true"
                        />
                    </div>
                    <div class="col-lg-6">
                        <x-forms.input
                            placeholder="Select Tests"
                            label="Tests"
                            type="select"
                            :options="$tests->map(fn ($test) => ['label' => $test->name,'value' => $test->id])->toArray()"
                            :required="false"
                            :value="old('test_ids[]',$disease->tests->map(fn($test) => $test->id))->toArray()"
                            input-name="test_ids[]"
                            input-id="test_ids"
                            :errors="$errors->get('test_ids')"
                            :multiple="true"
                        />
                    </div>
                </div>

                <div id="symptoms_container">
                    <div data-repeater-list="symptoms">
                        @foreach($disease->diagnoseSymptoms as $singleSymptom)
                            <div class="row mb-3" data-repeater-item >
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Symptoms</label>
                                        <select name="symptom_id" class="form-control">
                                            @foreach($symptoms as $symptom)
                                                <option {{ $singleSymptom->symptom_id == $symptom->id ? "selected" : "" }} value="{{$symptom->id}}">{{$symptom->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label># of Times in 24 hours</label>
                                        <input type="number" name="times" class="form-control" value="{{$singleSymptom->times}}" >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button data-repeater-delete class="btn btn-danger mt-4" type="button" >Delete</button>
                                </div>
                            </div>
                        @endforeach
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
            $("#criteria_ids").select2();
            $("#must_include_symptom_ids").select2();
            $("#must_include_criteria_ids").select2();
            $("#check_current_saturation").select2();
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
