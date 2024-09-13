@extends('admin.layouts.app')
@section('title') Criteria @endsection
@section('breadcrumb_1') Criteria @endsection
@section('breadcrumb_2') Create @endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('criteria.store') }}" method="post">
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
                <button type="submit" class="btn btn-success" >Save</button>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        window.onload = function(){
            $("#criteria_key").select2();
            $("#criteria_comparison_operator").select2();
        }
    </script>
@endsection
