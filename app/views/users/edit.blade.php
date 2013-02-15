@extends('layouts.default')

{{-- Content --}}
@section('content')
<form method="post" action="/users/{{  $user->_id }}" class="form-horizontal">
    <!-- First Name -->
    <div class="control-group {{ $errors->has('first_name') ? 'error' : '' }}">
        <label class="control-label" for="first_name">First Name</label>
        <div class="controls">
            <input type="text" name="first_name" id="first_name" value="{{  Input::old('first_name', $user->first_name) }}" />
            {{ $errors->first('first_name') }}
        </div>
    </div>
    <!-- ./ first name -->

    <!-- Last Name -->
    <div class="control-group {{ $errors->has('last_name') ? 'error' : '' }}">
        <label class="control-label" for="last_name">Last Name</label>
        <div class="controls">
            <input type="text" name="last_name" id="last_name" value="{{ Input::old('last_name', $user->last_name) }}" />
            {{ $errors->first('last_name') }}
        </div>
    </div>
    <!-- ./ last name -->

    <!-- Email -->
    <div class="control-group {{ $errors->has('email') ? 'error' : '' }}">
        <label class="control-label" for="email">Email</label>
        <div class="controls">
            <input type="text" name="email" id="email" value="{{ Input::old('email', $user->email) }}" />
            {{ $errors->first('email') }}
        </div>
    </div>
    <!-- ./ email -->

    <!-- Password -->
    <div class="control-group {{ $errors->has('password') ? 'error' : '' }}">
        <label class="control-label" for="password">Password</label>
        <div class="controls">
            <input type="password" name="password" id="password" value="" />
            {{ $errors->first('password') }}
        </div>
    </div>
    <!-- ./ password -->

    <!-- Password Confirm -->
    <div class="control-group {{ $errors->has('password_confirmation') ? 'error' : '' }}">
        <label class="control-label" for="password_confirmation">Password Confirm</label>
        <div class="controls">
            <input type="password" name="password_confirmation" id="password_confirmation" value="" />
            {{ $errors->first('password_confirmation') }}
        </div>
    </div>
    <!-- ./ password confirm -->

    <!-- Update button -->
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" onclick="document.location='/user'" class="btn">Cancel</button>
        </div>
    </div>
    <!-- ./ update button -->
</form>
@stop