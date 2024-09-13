@extends('admin.layouts.app')
@section('title') Diseases @endsection
@section('breadcrumb_1') Diseases @endsection
@section('breadcrumb_2') Create @endsection
@section('content')
    <style>
        hr {
            border-top: 1px solid #cccccc;
        }
    </style>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('diseases.update',$diagnose['id']) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <x-forms.input label="Name" placeholder="Enter Name" :errors="$errors->get('name')" :value="old('name',$diagnose['name'])" input-name="name" input-id="name" :required="true" />
                    </div>
                </div>
                <div id="conditions_container">
                    <div data-repeater-list="conditions" >
                        @foreach(old('conditions',$diagnose->diagnoseConditions) as $k=>$condition)
                            <div data-repeater-item>
                                <div class="d-flex flex-row justify-content-center">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="type" value="main" @checked($condition['type'] == 'main') >
                                            Main
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="type" value="and" @checked($condition['type'] == 'and') >
                                            And
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="type" value="or" @checked($condition['type'] == 'or') >
                                            Or
                                        </label>
                                    </div>
                                </div>
                                <div class="row mt-3" >
                                    <div class="col-md-2">
                                        <x-forms.input label="Any" type="number" step="1" min="1" placeholder="" :errors="$errors->get('compulsory_symptoms')" input-name="compulsory_symptoms" input-id="compulsory_symptoms" :required="true" :value="$condition['compulsory_symptoms']" />
                                    </div>
                                    <div class="col-md-10">
                                        <div id="cases_container">
                                            <div data-repeater-list="cases">
                                                @foreach($condition['cases'] as $case)
                                                    <div class="row mb-3" data-repeater-item >
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>of List</label>
                                                                <select name="case" class="form-control cases_selector" data-placeholder="Select Case" >
                                                                    <option value="">Select Case</option>
                                                                    <optgroup label="Symptoms">
                                                                        @foreach($symptoms as $symptom)
                                                                            <option @selected($case['case'] == 'symptom_'.$symptom->id) value="symptom_{{$symptom->id}}">{{$symptom->name}}</option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                    <optgroup label="Crterias">
                                                                        @foreach($criterias as $criteria)
                                                                            <option @selected($case['case'] == 'criteria_'.$criteria->id) value="criteria_{{$criteria->id}}">{{$criteria->name}}</option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Times in Last 24 hours</label>
                                                                <input type="number" name="times" class="form-control" value="{{$case['times'] ?? 1}}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-check mt-4">
                                                                <label class="form-check-label" >
                                                                    <input class="form-check-input" type="checkbox" value="1" name="must_include" @checked(isset($case['must_include']) and $case['must_include'][0]) />
                                                                    Must Include
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button data-repeater-delete class="btn btn-danger mt-4" type="button" >Delete</button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button data-repeater-create type="button" class="btn btn-primary" >Add More</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Check o2 Saturation <span class="text-danger" >*</span></label>
                                            <select name="check_o2_saturation" class="form-control" required>
                                                <option value="">Select</option>
                                                <option @selected($condition['check_o2_saturation'] == 'Yes') value="Yes">Yes</option>
                                                <option @selected($condition['check_o2_saturation'] == 'No') value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>O2 Difference Value</label>
                                            <input type="number" name="o2_saturation_difference_value" class="form-control" step="0.01" value="{{$condition['o2_saturation_difference_value'] ?? 0.0}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button data-repeater-delete class="btn btn-danger mt-4" type="button" >Delete Condition</button>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        @endforeach
                    </div>
                    <button data-repeater-create type="button" class="btn btn-primary mt-3">Add More Condition</button>
                </div>

                <div class="mt-3" ></div>

                <x-forms.input label="Tests" :required="true" input-name="test_ids[]" input-id="test_ids" :multiple="true"
                               placeholder="Select Tests" type="select" :value="old('test_ids')" :errors="$errors->get('test_ids')"
                               :options="$tests->map(fn ($test) => ['label' => $test->name,'value' => $test->id])->toArray()"/>

                <button type="submit" class="btn btn-success mt-3" >Save</button>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        window.onload = function(){
            $("#test_ids").select2();
            $("#check_current_saturation").select2();
            $("#conditions_container").repeater({
                isFirstItemUndeletable: true,
                repeaters: [{
                    isFirstItemUndeletable: true,
                    selector: '#cases_container',
                    show: function () {
                        $(this).slideDown();
                        $($($($(this).children()[0]).children()[0]).children()[1]).select2();
                        $($($($(this).children()[1]).children()[0]).children()[1]).val(1);
                    },
                    hide: function (nestedDeleteElement) {
                        $(this).slideUp(nestedDeleteElement);
                    },
                }],
                show: function () {
                    $(this).slideDown();
                    $($(this).children()[1].children[1].children[0].children[0].children[0].children[0].children[0].children[1]).select2();
                    $($($($($($($($($(this).children()[1]).children()[1]).children()[0]).children()[0]).children()[0]).children()[1]).children()[0]).children()[1]).val(1);
                    $($($($($(this).children()[0]).children()[0]).children()[0]).children()[0]).attr('disabled',true)
                    $($($($($(this).children()[0]).children()[1]).children()[0]).children()[0]).prop('checked',true)
                },
                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                },
            });
            $("[name='conditions[0][type]'][value='or']").attr('disabled',true);
            $("[name='conditions[0][type]'][value='and']").attr('disabled',true);
            $("[name='conditions[0][cases][0][case]']").select2();
        }
    </script>
@endsection
