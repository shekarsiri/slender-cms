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

@section('css')
	<!-- jQuery tag plugin -->
	<link href="{{ asset('assets/css/bootstrap-tagmanager.css') }}" rel="stylesheet">
	<!-- jQuery datetime plugin -->
	<link href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection

@section('js')
	<!-- jQuery tag plugin -->
	<script src="{{ asset('assets/js/bootstrap-tagmanager.js') }}"></script>
	<script>
		$(function(){
			jQuery(".tagManager").tagsManager({
		        prefilled: [{{ (isset($page->meta['keywords']) && $page->meta['keywords']) ? "'".implode("', '", (array)$page->meta['keywords'])."'" : '' }}],
		        preventSubmitOnEnter: true,
		        typeahead: true,
		        typeaheadAjaxSource: null,
		        blinkBGColor_1: '#FFFF9C',
		        blinkBGColor_2: '#CDE69C',
		        hiddenTagListName: 'meta_keywords'
		      });
		      $('#datetimepicker1').datetimepicker();
		      $('#datetimepicker2').datetimepicker();
		});
	</script>
	<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
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
			<input type="text" name="_meta_keywords"  class="tagManager input-xlarge" id="meta_keywords" value="{{  Input::old('meta_keywords',  isset($page->meta['keywords'])?$page->meta['keywords']:'') }}" />
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

	<!-- availability.sunrise -->
	<div class="control-group {{ $errors->has('availability_sunrise') ? 'error' : '' }}">
		<label class="control-label" for="availability_sunrise">Sunrise</label>
		<div class="controls">
			<div id="datetimepicker1" class="input-append date">
				<input type="text" data-format="MM/dd/yyyy hh:mm:ss" name="availability_sunrise" id="availability_sunrise" value="{{  Input::old('availability_sunrise', isset($page->availability['sunrise']) && $page->availability['sunrise'] ? date("m/d/Y H:i:s", $page->availability['sunrise']->sec) : '') }}" />
				<span class="add-on"><i class="icon-envelope"></i></span>

			</div>
			{{ $errors->first('availability_sunrise') }}
		</div>
	</div>
	<!-- ./ availability.sunrise -->		

	<!-- availability.sunset -->
	<div class="control-group {{ $errors->has('availability_sunset') ? 'error' : '' }}">
		<label class="control-label" for="availability_sunset">Sunset</label>
		<div class="controls">
			<div id="datetimepicker2" class="input-append date">
				<input type="text" data-format="MM/dd/yyyy hh:mm:ss" name="availability_sunset" id="availability_sunset" value="{{  Input::old('availability_sunset', isset($page->availability['sunset']) && $page->availability['sunset'] ? date("m/d/Y H:i:s", $page->availability['sunset']->sec) : '') }}" />
				<span class="add-on"><i class="icon-envelope"></i></span>

			</div>
			{{ $errors->first('availability_sunset') }}
		</div>
	</div>
	<!-- ./ availability.sunset -->
	
	<!-- update button -->
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-primary">@if ($page->name) Update @else Save @endif</button>
			<button type="button" onclick="document.location='/page'" class="btn">Cancel</button>
		</div>
	</div>
	<!-- ./ update button -->
</form>
@endsection
