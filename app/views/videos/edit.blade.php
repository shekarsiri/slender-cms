@extends('layouts.default')


@section('content')
<h2>Edit {{ ucfirst(str_singular($package)) }}</h2>

<form method="{{ $method }}" action="" class="form-horizontal">
    <input type="hidden" name="_method" value="PUT">
    @foreach ($options->fields as $field => $option)
    @if($field == 'urls' || $field == 'availability')
    @foreach ($option as $subfield => $suboption)
    <div class="control-group {{ $errors->has($subfield) ? 'error' : '' }}">
        <label class="control-label" for="{{ $subfield }}">{{ $field }} {{$subfield}}</label>
        <div class="controls">
            <input type="text"
            @if($suboption->type == 'DateTime')
            class="datepicker"
            @endif
            name="{{$field}}_{{ $subfield }}" id="{{ $subfield }}" value="{{ Input::old($field, $data->$subfield) }}" />
            {{{ $errors->first($field) }}}
        </div>
    </div>
    @endforeach
    @else
    <div class="control-group {{ $errors->has($field) ? 'error' : '' }}">
        <label class="control-label" for="{{ $field }}">{{ $field }}</label>
        <div class="controls">
            <input type="text"
            @if($option->type == 'DateTime')
            class="datepicker"
            @endif
            name="{{ $field }}" id="{{ $field }}" value="{{ Input::old($field, $data->$field) }}" />
            {{{ $errors->first($field) }}}
        </div>
    </div>
    @endif
    @endforeach

    <!-- Create button -->
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" onclick="document.location='/{{ $package }}'" class="btn">Cancel</button>
        </div>
    </div>
    <!-- ./ Create button -->
</form>
@stop
