@layout('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
:: Sites
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
	<h1>@if ($site->name) Site Settings @else New Site @endif</h1>
</div>
<form method="post" action="" class="form-horizontal">
	<!-- Site Name -->
	<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
		<label class="control-label" for="name">Site Name</label>
		<div class="controls">
			<input type="text" name="name" id="name" value="{{  Input::old('name', $site->name) }}" />
			{{ $errors->first('name') }}
		</div>
	</div>
	<!-- ./ site name -->


	<!-- Site Description -->
	<div class="control-group {{ $errors->has('description') ? 'error' : '' }}">
		<label class="control-label" for="description">Description</label>
		<div class="controls">
			<textarea name="description" id="description" class="input-xxlarge" rows="3">{{  Input::old('description', $site->description) }}</textarea>
			{{ $errors->first('description') }}
		</div>
	</div>
	<!-- ./ Site Description -->

	<!-- Site URL -->
	<div class="control-group {{ $errors->has('url') ? 'error' : '' }}">
		<label class="control-label" for="url">Site URL</label>
		<div class="controls">
			<input type="text" name="url" id="url" value="{{  Input::old('url', $site->url) }}" />
			{{ $errors->first('url') }}
		</div>
	</div>
	<!-- ./ site URL -->

	
	<!-- Update button -->
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-primary">@if ($site->name) Update @else Save @endif</button>
			<button type="button" onclick="document.location='/site'" class="btn">Cancel</button>
		</div>
	</div>
	<!-- ./ update button -->
</form>
@endsection
