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


	<!-- permissions -->
	<div class="control-group">
		<label class="control-label">Permissions</label>
		<div class="controls">
			
			<label class="checkbox inline">
			  <input type="checkbox" id="inlineCheckbox1" value="option1"> All
			</label>
			<label class="checkbox inline">
			  <input type="checkbox" id="inlineCheckbox2" value="option2"> All
			</label>
			<label class="checkbox inline">
			  <input type="checkbox" id="inlineCheckbox3" value="option3"> All
			</label>

		</div>
	</div>
	<!-- ./ permissions -->

	<!-- permissions -->
	<div class="control-group">
		<label class="control-label">Site</label>
		<div class="controls">
			
			<label class="checkbox inline">
			  <input type="checkbox" id="inlineCheckbox1" value="option1"> View
			</label>
			<label class="checkbox inline">
			  <input type="checkbox" id="inlineCheckbox2" value="option2"> Edit
			</label>
			<label class="checkbox inline">
			  <input type="checkbox" id="inlineCheckbox3" value="option3"> Delete
			</label>

		</div>
	</div>
	<!-- ./ permissions -->

	<!-- permissions -->
	<div class="control-group">
		<label class="control-label">Video</label>
		<div class="controls">
			
			<label class="checkbox inline">
			  <input type="checkbox" id="inlineCheckbox1" value="option1"> View
			</label>
			<label class="checkbox inline">
			  <input type="checkbox" id="inlineCheckbox2" value="option2"> Edit
			</label>
			<label class="checkbox inline">
			  <input type="checkbox" id="inlineCheckbox3" value="option3"> Delete
			</label>

		</div>
	</div>
	<!-- ./ permissions -->



	<!-- Update button -->
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn">Update</button>
		</div>
	</div>
	<!-- ./ update button -->
</form>
@endsection