@extends('layouts.default')

{{-- Content --}}
@section('content')
<h2>{{ ucfirst($package) }}</h2>
<form method="{{ $method }}" action="" class="form-horizontal">
    <input type="hidden" name="_method" value="PUT">
    @foreach ($options->fields as $field => $option)

        <div class="control-group {{ $errors->has($field) ? 'error' : '' }}">
            <label class="control-label" for="{{ $field }}">{{ $field }}</label>
            <div class="controls">
                <input type="text" name="{{ $field }}" id="{{ $field }}" value="{{  Input::old($field, $data->$field) }}" />
                {{{ $errors->first($field) }}}
            </div>
        </div>

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
