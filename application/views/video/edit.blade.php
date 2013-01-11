@layout('layouts.default')

{{-- Web page Title --}}
@section('title')
@parent
:: Video
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

	<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
	<script>
		$(function(){
			
			jQuery(".tagManager").tagsManager({
		        prefilled: [{{ $video->tags ? "'".implode("', '", (array)$video->tags)."'" : '' }}],
		        preventSubmitOnEnter: true,
		        typeahead: true,
		        typeaheadAjaxSource: null,
		        blinkBGColor_1: '#FFFF9C',
		        blinkBGColor_2: '#CDE69C',
		        hiddenTagListName: 'tags'
		      });
			$('#datetimepicker1').datetimepicker();
		});	
	</script>
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
		<label class="control-label" for="slug">Slug</label>
		<div class="controls">
			<input type="text" name="slug" id="slug" value="{{  Input::old('slug', $video->slug) }}" />
			{{ $errors->first('slug') }}
		</div>
	</div>
	<!-- ./ video slug -->

	<!-- video tags -->
	<div class="control-group {{ $errors->has('tags') ? 'error' : '' }}">
		<label class="control-label" for="tags">Tags</label>
		<div class="controls">
			<input type="text" id="tags" name="_tags" placeholder="Tags" class="tagManager" value="{{  Input::old('tags', $video->tags) }}" />
			{{ $errors->first('tags') }}
		</div>
	</div>
	<!-- ./ video tags -->
	<!-- video premiere date -->
	<div class="control-group {{ $errors->has('premiere_date') ? 'error' : '' }}">
		<label class="control-label" for="premiere_date">Premiere Date</label>
		<div class="controls">
			<div id="datetimepicker1" class="input-append date">
				<input type="text" data-format="MM/dd/yyyy hh:mm:ss" name="premiere_date" id="premiere_date" value="{{  Input::old('premiere_date', $video->premiere_date ? date("m/d/Y H:i:s",$video->premiere_date->sec) : '') }}" />
				<span class="add-on"><i class="icon-envelope"></i></span>

			</div>
			{{ $errors->first('premiere_date') }}
		</div>
	</div>
	<!-- ./ video premiere date -->	


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
