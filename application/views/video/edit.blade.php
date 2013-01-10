@layout('layouts.default')

{{-- Web page Title --}}
@section('title')
@parent
:: Video
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
	<h1>@if ($video->title) Video Settings @else New Video @endif</h1>
</div>
<form method="post" action="" class="form-horizontal">
	<!-- video title -->
	<div class="control-group {{ $errors->has('title') ? 'error' : '' }}">
		<label class="control-label" for="title">Title</label>
		<div class="controls">
			<input type="text" name="title" id="title" value="{{  Input::old('title', $video->title) }}" />
			{{ $errors->first('title') }}
		</div>
	</div>
	<!-- ./ video title -->


	<!-- video Description -->
	<div class="control-group {{ $errors->has('description') ? 'error' : '' }}">
		<label class="control-label" for="description">Description</label>
		<div class="controls">
			<textarea name="description" id="description" class="input-xxlarge" rows="3">{{  Input::old('description', $video->description) }}</textarea>
			{{ $errors->first('description') }}
		</div>
	</div>
	<!-- ./ video Description -->


	<!-- video slug -->
	<div class="control-group {{ $errors->has('slug') ? 'error' : '' }}">
		<label class="control-label" for="title">Slug</label>
		<div class="controls">
			<input type="text" name="slug" id="slug" value="{{  Input::old('slug', $video->slug) }}" />
			{{ $errors->first('slug') }}
		</div>
	</div>
	<!-- ./ video slug -->
	
	<!-- Update button -->
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-primary">@if ($video->name) Update @else Save @endif</button>
			<button type="button" onclick="document.location='/video'" class="btn">Cancel</button>
		</div>
	</div>
	<!-- ./ update button -->
</form>
@endsection
