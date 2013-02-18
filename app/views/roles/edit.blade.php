@extends('layouts.default')

{{-- Content --}}
@section('content')
<h2>{{ ucfirst($package) }}</h2>
<form method="{{ $method }}" action="" class="form-horizontal">
    <input type="hidden" name="_method" value="PUT">

    {{-- var_dump($options) --}}

    @foreach ($options->fields as $field => $option)
        {{-- var_dump($option) --}}
        @if(is_array($option))
        <div class="control-group {{ $errors->has($field) ? 'error' : '' }}">
            <label class="control-label" for="{{ $field }}">{{ $field }}</label>
            <div class="controls">
                <input type="text" name="{{ $field }}" id="{{ $field }}" value="{{ Input::old($field, $data->$field) }}" />
                {{{ $errors->first($field) }}}
            </div>
        </div>
        @else
            <!-- Missing nested fields display -->
        @endif

    @endforeach
        <div class="control-group">
            <label class="control-label">Permissions</label>

            <div class="controls span5">
                <table class="table table-bordered table-condensed">
                  <thead>
                    <tr>
                      <th>Global</th>
                      <th>Read</th>
                      <th>Write</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="info">
                        <td>Sites</td>
                        <td>
                            <label class="checkbox inline">
                                <input type="checkbox" onclick="$('input.access_view').prop('checked', $(this).prop('checked'));">
                            </label>
                        </td>
                        <td>
                            <label class="checkbox inline">
                                <input type="checkbox" onclick="$('input.access_view').prop('checked', $(this).prop('checked'));">
                            </label>
                        </td>
                        <td>
                            <label class="checkbox inline">
                              <input type="checkbox" onclick="$('input.access_view').prop('checked', $(this).prop('checked'));">
                            </label>
                        </td>
                    </tr>
                    <tr class="info">
                        <td>Roles</td>
                        <td>
                            <label class="checkbox inline">
                                <input type="checkbox" onclick="$('input.access_view').prop('checked', $(this).prop('checked'));">
                            </label>
                        </td>
                        <td>
                            <label class="checkbox inline">
                                <input type="checkbox" onclick="$('input.access_view').prop('checked', $(this).prop('checked'));">
                            </label>
                        </td>
                        <td>
                            <label class="checkbox inline">
                              <input type="checkbox" onclick="$('input.access_view').prop('checked', $(this).prop('checked'));">
                            </label>
                        </td>
                    </tr>
                    <tr class="info">
                        <td>Users</td>
                        <td>
                            <label class="checkbox inline">
                                <input type="checkbox" onclick="$('input.access_view').prop('checked', $(this).prop('checked'));">
                            </label>
                        </td>
                        <td>
                            <label class="checkbox inline">
                                <input type="checkbox" onclick="$('input.access_view').prop('checked', $(this).prop('checked'));">
                            </label>
                        </td>
                        <td>
                            <label class="checkbox inline">
                              <input type="checkbox" onclick="$('input.access_view').prop('checked', $(this).prop('checked'));">
                            </label>
                        </td>
                    </tr>
                    </tbody>
                    <thead>
                        <tr>
                          <th>Site A</th>
                          <th>Read</th>
                          <th>Write</th>
                          <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Videos</td>
                            <td>
                                <label class="checkbox inline">
                                    <input type="checkbox" onclick="$('input.access_view').prop('checked', $(this).prop('checked'));">
                                </label>
                            </td>
                            <td>
                                <label class="checkbox inline">
                                    <input type="checkbox" onclick="$('input.access_view').prop('checked', $(this).prop('checked'));">
                                </label>
                            </td>
                            <td>
                                <label class="checkbox inline">
                                  <input type="checkbox" onclick="$('input.access_view').prop('checked', $(this).prop('checked'));">
                                </label>
                            </td>
                        </tr>
                    
                  </tbody>
                                    
                </table>
            </div>
        </div>   
        
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
