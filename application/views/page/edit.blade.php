@layout('layouts.default')

{{-- Web page Title --}}
@section('title')
@parent
:: Page
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
	<h1>@if ($page->title) Page Settings @else New Page @endif</h1>
</div>
<form method="post" action="" class="form-horizontal">
	<!-- page title -->
	<div class="control-group {{ $errors->has('title') ? 'error' : '' }}">
		<label class="control-label" for="title">Page Title</label>
		<div class="controls">
			<input type="text" name="title" id="title" value="{{  Input::old('title', $page->title) }}" />
			{{ $errors->first('title') }}
		</div>
	</div>
	<!-- ./ page title -->


	<!-- page meta_title -->
	<div class="control-group {{ $errors->has('meta_title') ? 'error' : '' }}">
		<label class="control-label" for="title">Meta Title</label>
		<div class="controls">
			<input type="text" name="meta_title" id="meta_title" value="{{  Input::old('meta_title', $page->meta['title']) }}" />
			{{ $errors->first('meta_title') }}
		</div>
	</div>
	<!-- ./ page meta_title -->


	<!-- page meta_keywords -->
	<div class="control-group {{ $errors->has('meta_keywords') ? 'error' : '' }}">
		<label class="control-label" for="title">Meta Keywords</label>
		<div class="controls">
			<input type="text" name="meta_keywords" class="input-xlarge" id="meta_keywords" value="{{  Input::old('meta_keywords',  isset($page->meta['keywords'])?$page->meta['keywords']:'') }}" />
			{{ $errors->first('meta_keywords') }}
		</div>
	</div>
	<!-- ./ page meta_keywords -->

	<!-- page body -->
	<div class="control-group {{ $errors->has('body') ? 'error' : '' }}">
		<label class="control-label" for="description">Page Body</label>
		<div class="controls">
			<textarea name="body" id="body" class="input-xxlarge" rows="3">{{  Input::old('body', $page->body) }}</textarea>
			{{ $errors->first('body') }}
		</div>
	</div>
	<!-- ./ page body -->


	<!-- page slug -->
	<div class="control-group {{ $errors->has('slug') ? 'error' : '' }}">
		<label class="control-label" for="title">Slug</label>
		<div class="controls">
			<input type="text" name="slug" id="slug" value="{{  Input::old('slug', $page->slug) }}" />
			{{ $errors->first('slug') }}
		</div>
	</div>
	<!-- ./ page slug -->


	
	<!-- Update button -->
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-primary">@if ($page->name) Update @else Save @endif</button>
			<button type="button" onclick="document.location='/page'" class="btn">Cancel</button>
		</div>
	</div>
	<!-- ./ update button -->
</form>
@endsection
