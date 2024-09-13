@extends('admin.layouts.app')
@section('title') Facilities @endsection
@section('breadcrumb_1') Facilities @endsection
@section('breadcrumb_2') Edit @endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('facilities.update',$facility->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    @foreach($fields as $field)
                        <div class="col-lg-6">
                            @if($field and isset($field['name']))
                                @php
                                    $fieldName = $field['name'];
                                @endphp
                                @if($fieldName != 'admin_ids[]')
                                    <x-forms.input :input-name="$field['name']" :input-id="$field['id']" :type="$field['type']"
                                                   :label="$field['label']" :placeholder="$field['placeholder']" :value="old($field['name'],$facility->$fieldName)"
                                                   :errors="$errors->get($field['name'])" :required="$field['required']" :options="$field['options']" :multiple="$field['multiple'] ?? false"
                                    />
                                @else
                                    <x-forms.input :input-name="$field['name']" :input-id="$field['id']" :type="$field['type']"
                                       :label="$field['label']" :placeholder="$field['placeholder']" :value="old($field['name'],$facility->admins->pluck('id')->toArray())"
                                       :errors="$errors->get($field['name'])" :required="$field['required']" :options="$field['options']" :multiple="$field['multiple'] ?? false"
                                    />
                                @endif
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
        window.onload = function() {
            $("#admin_ids").select2();
        }
    </script>
@endsection
