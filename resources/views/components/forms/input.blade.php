<div @class(['form-group','mb-3']) >
    <label for="{{$inputId}}">{{$label}} @if($required) <span class="text-danger" >*</span> @endif</label>
    @if($type != 'textarea' and $type != 'select')
        <input type="{{$type}}" name="{{$inputName}}" placeholder="{{$placeholder}}" value="{{$value}}" @class(['form-control','is-invalid' => count($errors) > 0,'is-valid' => $valid == true]) id="{{$inputId}}" {{$required ? "required" : ""}} step="{{$step}}" min="{{$numberMin}}" accept="{{$accept}}" @disabled($disabled) />
    @elseif($type == 'textarea')
        <textarea name="{{$inputName}}" id="{{$inputId}}" @class(['form-control','is-invalid' => count($errors) > 0,'is-valid' => $valid]) placeholder="{{$placeholder}}" @disabled($disabled) >{{$value}}</textarea>
    @else
        @if(!$multiple)
            <select name="{{$inputName}}" id="{{$inputId}}" @class(['form-control','is-invalid' => count($errors) > 0,'is-valid' => $valid]) {{$required ? "required" : ""}} @disabled($disabled)  >
                <option value="" >{{$placeholder}}</option>
                @foreach($options as $option)
                    <option {{ $option['value'] == $value ? "selected" : "" }} value="{{ $option['value'] }}">{{$option['label']}}</option>
                @endforeach
            </select>
        @else
            <select data-placeholder="{{$placeholder}}" name="{{$inputName}}" id="{{$inputId}}" @class(['select2','form-control','select2-multiple','is-invalid' => count($errors) > 0,'is-valid' => $valid]) {{$required ? "required" : ""}} multiple @disabled($disabled)  >
                @foreach($options as $option)
                    <option {{ (is_array($value) and in_array($option['value'],$value)) ? "selected" : "" }} value="{{ $option['value'] }}">{{$option['label']}}</option>
                @endforeach
            </select>
        @endif
    @endif
    <div class="invalid-feedback">
        {!! implode("<br/>",$errors) !!}
    </div>
    <div class="valid-feedback">
        {{$validMessage}}
    </div>
</div>
