@extends('admin.layouts.app')
@section('title')
Dashboard
@endsection
@section('breadcrumb_1')
Dashboard
@endsection
@section('content')
@if(auth()->user()->role->name === config('constants.roles.admin'))
<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="text-center">Compare Facilities / Groups</h3>
               <div class="compare-box mt-4">
                   <form action="{{ route('home.compare-facilities') }}" method="get">
                       <div class="row">
                           <div class="col-md-6">
                               <div class="form-group mb-3">
                                   <label for="facility_group_id_1" >Facility / Group</label>
                                   <select class="form-control" name="facility_group_id_1" id="facility_group_id_1" data-placeholder="Select Facility / Group">
                                       <option value="">Select Facility / Group</option>
                                       <optgroup label="Facilities">
                                           @foreach($facilities as $facility)
                                               <option {{ (request()->facility_group_id_1 and request()->facility_group_id_1 === 'facility_'.$facility->id) ? "selected" : "" }} value="facility_{{ $facility->id }}">{{ $facility->name }}</option>
                                           @endforeach
                                       </optgroup>
                                       <optgroup label="Groups">
                                           @foreach($groups as $group)
                                               <option {{ (request()->facility_group_id_1 and request()->facility_group_id_1 === 'group_'.$group->id) ? "selected" : "" }} value="group_{{ $group->id }}">{{ $group->name }}</option>
                                           @endforeach
                                       </optgroup>
                                   </select>
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="form-group mb-3">
                                   <label for="facility_group_id_2">Facility / Group</label>
                                   <select class="form-control" name="facility_group_id_2" id="facility_group_id_2" data-placeholder="Select Facility / Group">
                                       <option value="">Select Facility / Group</option>
                                       <optgroup label="Facilities">
                                           @foreach($facilities as $facility)
                                               <option {{ (request()->facility_group_id_2 and request()->facility_group_id_2 === 'facility_'.$facility->id) ? "selected" : "" }} value="facility_{{ $facility->id }}">{{ $facility->name }}</option>
                                           @endforeach
                                       </optgroup>
                                       <optgroup label="Groups">
                                           @foreach($groups as $group)
                                               <option {{ (request()->facility_group_id_2 and request()->facility_group_id_2 === 'group_'.$group->id) ? "selected" : "" }} value="group_{{ $group->id }}">{{ $group->name }}</option>
                                           @endforeach
                                       </optgroup>
                                   </select>
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="symptom_ids">Symptoms</label>
                                   <select name="symptom_ids[]" id="symptom_ids" class="form-control" multiple data-placeholder="Select Symptoms" >
                                       @foreach($symptoms as $symptom)
                                           <option {{ (request()->symptom_ids and in_array($symptom->id,request()->symptom_ids)) ? "selected" : "" }} value="{{ $symptom->id }}">{{ $symptom->name }}</option>
                                       @endforeach
                                   </select>
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="disease_ids">Diseases</label>
                                   <select name="disease_ids[]" id="disease_ids" class="form-control" multiple data-placeholder="Select Diseases" >
                                       @foreach($diseases as $disease)
                                           <option {{ (request()->disease_ids and in_array($disease->id,request()->disease_ids)) ? "selected" : "" }} value="{{ $disease->id }}">{{ $disease->name }}</option>
                                       @endforeach
                                   </select>
                               </div>
                           </div>
                           <div class="col-md-2 mt-3">
                               <button type="submit" class="btn btn-success" >Compare</button>
                           </div>
                       </div>
                   </form>
               </div>
            </div>
        </div>
        @if($comparison_data)
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if($facility_1['type'] === 'facility')
                                <h5>Facility Name: {{$facility_1['data']->name}}</h5>
                            @elseif($facility_1['type'] === 'group')
                                <h5>
                                    Group Name: {{$facility_1['data']->name}}<br>
                                    @foreach($facility_1['data']->facilities() as $k=>$facility)
                                        {{$facility->name}}{{ ($k == (count($facility_1['data']->facilities()) - 1)) ? '' : ', ' }}
                                    @endforeach
                                </h5>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($facility_2['type'] === 'facility')
                                <h5>Facility Name: {{$facility_2['data']->name}}</h5>
                            @elseif($facility_2['type'] === 'group')
                                <h5>
                                    Group Name: {{$facility_2['data']->name}}<br>
                                    @foreach($facility_2['data']->facilities() as $k=>$facility)
                                        {{$facility->name}}{{ ($k == (count($facility_2['data']->facilities()) - 1)) ? '' : ', ' }}
                                    @endforeach
                                </h5>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover text-center w-100">
                                    @if($facility_1['type'] === 'facility')
                                        <tr>
                                            <th>Total Symptoms</th>
                                            <td>{{ $facility_1['data']->general_total_symptoms }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Diseases</th>
                                            <td>{{ $facility_1['data']->general_total_diseases }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Assessments</th>
                                            <td>{{ $facility_1['data']->general_total_assessments }}</td>
                                        </tr>
                                    @else
                                        @php
                                        $totalSymptoms = 0;
                                        $totalDiseases = 0;
                                        $totalAssessments = 0;
                                        @endphp
                                        @foreach($facility_1['data']->facilities() as $facility)
                                            @php
                                            $totalSymptoms += $facility->general_total_symptoms;
                                            $totalDiseases += $facility->general_total_diseases;
                                            $totalAssessments += $facility->general_total_assessments;
                                            @endphp
                                        @endforeach
                                        <tr>
                                            <th>Total Symptoms</th>
                                            <td>{{ $totalSymptoms }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Diseases</th>
                                            <td>{{ $totalDiseases }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Assessments</th>
                                            <td>{{ $totalAssessments }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover text-center w-100">
                                    @if($facility_2['type'] === 'facility')
                                        <tr>
                                            <th>Total Symptoms</th>
                                            <td>{{ $facility_2['data']->general_total_symptoms }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Diseases</th>
                                            <td>{{ $facility_2['data']->general_total_diseases }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Assessments</th>
                                            <td>{{ $facility_2['data']->general_total_assessments }}</td>
                                        </tr>
                                    @else
                                        @php
                                            $totalSymptoms = 0;
                                            $totalDiseases = 0;
                                            $totalAssessments = 0;
                                        @endphp
                                        @foreach($facility_2['data']->facilities() as $facility)
                                            @php
                                                $totalSymptoms += $facility->general_total_symptoms;
                                                $totalDiseases += $facility->general_total_diseases;
                                                $totalAssessments += $facility->general_total_assessments;
                                            @endphp
                                        @endforeach
                                        <tr>
                                            <th>Total Symptoms</th>
                                            <td>{{ $totalSymptoms }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Diseases</th>
                                            <td>{{ $totalDiseases }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Assessments</th>
                                            <td>{{ $totalAssessments }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body">
                <div class="title mb-3">
                    <h4>Create Alerts</h4>
                </div>
                <div class="form-group">
                    <select class="form-control">
                        <option value="">All</option>
                        @foreach($facilities as $facility)
                            <option value="{{$facility->id}}">{{ $facility->name }}</option>
                        @endforeach
                    </select>
                </div>
                <h5 class="text-center my-3">Reaches</h5>
                <div class="input-group align-items-center">
                    <input type="text" placeholder="Amount" class="form-control">
                </div>
                <h5 class="text-center my-3">OF</h5>
                <div class="form-group mb-2">
                    <select class="form-control">
                        <option selected value="">Any/All symptoms</option>
                        @foreach($symptoms as $symptom)
                            <option value="{{ $symptom->id }}">{{ $symptom->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-2">
                    <select class="form-control">
                        <option selected>Any/All Diseases</option>
                        @foreach($diseases as $disease)
                            <option value="{{ $disease->id }}">{{ $disease->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-2">
                    <select class="form-control">
                        <option selected>Any/All Response</option>
                        <option>Response 01</option>
                        <option>Response 02</option>
                        <option>Response 03</option>
                        <option>Response 04</option>
                        <option>Response 05</option>
                    </select>
                </div>
                <div class="button-group mb-3">
                    <button class="btn btn-primary w-100">Set</button>
                </div>
                <div class="group-box">
                    <h4 class="title mb-3">Create Group</h4>
                    <form action="{{ route('groups.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="group_name">Group Name</label>
                            <input placeholder="Enter Group Name" type="text" class="form-control" id="group_name" name="group_name" >
                        </div>
                        <div class="form-group mt-3">
                            <label for="facility_ids">Facilities</label>
                            <select name="facility_ids[]" id="facility_ids" class="form-control" multiple data-placeholder="Select Facility">
                                @foreach($facilities as $facility)
                                    <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100 mt-3" >Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
