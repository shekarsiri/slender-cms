@layout('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
:: Account
@endsection

{{-- New Laravel 4 Feature in use --}}
@section('styles')
@parent
body {
	background: #f2f2f2;
}
@endsection

{{-- Content --}}
@section('content')
<div class="page-header">
	<h1>Edit your settings</h1>
</div>
<form method="post" action="" class="form-horizontal">
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



@if ($user->has_access("user.view")) 

<div class="well">
	<!-- permissions -->
	<div class="control-group">
		<label class="control-label">Permissions</label>
		<div class="controls">
			
			<label class="checkbox inline span1">
			  <input type="checkbox" onclick="$('input.access_view').prop('checked', $(this).prop('checked'));"> All
			</label>
			<label class="checkbox inline span1">
			  <input type="checkbox" onclick="$('input.access_edit').prop('checked', $(this).prop('checked'));"> All
			</label>
			<label class="checkbox inline span1">
			  <input type="checkbox" onclick="$('input.access_delete').prop('checked', $(this).prop('checked'));"> All
			</label>

		</div>
	</div>
	<!-- ./ permissions -->
	<hr/>
@if (Auth::user()->has_access("user.edit") || Auth::user()->has_access("user.view"))
	<!-- permissions -->
	<div class="control-group">
		<label class="control-label">User</label>
		<div class="controls">
			<label class="checkbox inline span1">
			  <input type="checkbox" name="access[user][view]" class='access_view' @if ($user->has_access("user.view")) checked @endif value="1"> View
			</label>
			<label class="checkbox inline span1">
			  <input type="checkbox" name="access[user][edit]"  class='access_edit' @if ($user->has_access("user.edit")) checked @endif value="1"> Edit
			</label>
			<label class="checkbox inline span1">
			  <input type="checkbox" name="access[user][delete]"  class='access_delete' @if ($user->has_access("user.delete")) checked @endif value="1"> Delete
			</label>

		</div>
	</div>
	<!-- ./ permissions -->
@endif	
	
@foreach (Config::get('tv4.modules') as $module => $conf)
	@if ($module!='user')
	<!-- permissions -->
	<div class="control-group">
		<label class="control-label">{{ ucfirst($module) }}</label>
		<div class="controls">
			<label class="checkbox inline span1">
			  <input type="checkbox" name="access[{{ $module }}][view]" class='access_view' @if ($user->has_access("{$module}.view")) checked @endif value="1"> View
			</label>
			<label class="checkbox inline span1">
			  <input type="checkbox" name="access[{{ $module }}][edit]"  class='access_edit' @if ($user->has_access("{$module}.edit")) checked @endif value="1"> Edit
			</label>
			<label class="checkbox inline span1">
			  <input type="checkbox" name="access[{{ $module }}][delete]"  class='access_delete' @if ($user->has_access("{$module}.delete")) checked @endif value="1"> Delete
			</label>

		</div>
	</div>
	<!-- ./ permissions -->
	@endif
@endforeach
</div>

@endif

	<!-- Update button -->
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-primary">Update</button>
		</div>
	</div>
	<!-- ./ update button -->
</form>
@endsection
