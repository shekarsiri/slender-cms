@layout('layouts.default')

{{-- Web page Title --}}
@section('title')
@parent
:: Channel
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
		        prefilled: [{{ $channel->tags ? "'".implode("', '", (array)$channel->tags)."'" : '' }}],
		        preventSubmitOnEnter: true,
		        typeahead: true,
		        typeaheadAjaxSource: null,
		        blinkBGColor_1: '#FFFF9C',
		        blinkBGColor_2: '#CDE69C',
		        hiddenTagListName: 'tags'
		      });
			$('#datetimepicker1').datetimepicker();
		    $('#datetimepicker2').datetimepicker();

			$('.typeahead').typeahead({
				source: [
					@foreach (Config::get('tv4.genre_list') as $genre) 
						"{{ $genre }}",
					@endforeach
				]
			});

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
	<h1>@if ($channel->title) Channel Settings @else New Channel @endif</h1>
</div>
<form method="post" action="" class="form-horizontal">
	<!-- channel title -->
	<div class="control-group {{ $errors->has('title') ? 'error' : '' }}">
		<label class="control-label" for="title">Title</label>
		<div class="controls">
			<input type="text" name="title" id="title" value="{{  Input::old('title', $channel->title) }}" />
			{{ $errors->first('title') }}
		</div>
	</div>
	<!-- ./ channel title -->


	<!-- channel Description -->
	<div class="control-group {{ $errors->has('description') ? 'error' : '' }}">
		<label class="control-label" for="description">Description</label>
		<div class="controls">
			<textarea name="description" id="description" class="input-xxlarge" rows="3">{{  Input::old('description', $channel->description) }}</textarea>
			{{ $errors->first('description') }}
		</div>
	</div>
	<!-- ./ channel Description -->


	<!-- channel slug -->
	<div class="control-group {{ $errors->has('slug') ? 'error' : '' }}">
		<label class="control-label" for="slug">Slug</label>
		<div class="controls">
			<input type="text" name="slug" id="slug" value="{{  Input::old('slug', $channel->slug) }}" />
			{{ $errors->first('slug') }}
		</div>
	</div>
	<!-- ./ channel slug -->

	<!-- channel tags -->
	<div class="control-group {{ $errors->has('tags') ? 'error' : '' }}">
		<label class="control-label" for="tags">Tags</label>
		<div class="controls">
			<input type="text" id="tags" name="_tags" placeholder="Tags" class="tagManager" value="{{  Input::old('tags', $channel->tags) }}" />
			{{ $errors->first('tags') }}
		</div>
	</div>
	<!-- ./ channel tags -->

	<!-- channel genre -->
	<div class="control-group {{ $errors->has('genre') ? 'error' : '' }}">
		<label class="control-label" for="genre">Genre</label>
		<div class="controls">
			<input type="text" name="genre" id="genre" autocomplete="off" class="typeahead" value="{{  Input::old('genre', $channel->genre) }}" />
			{{ $errors->first('genre') }}
		</div>
	</div>
	<!-- ./ channel genre -->
	
	<!-- start_date -->
	<div class="control-group {{ $errors->has('start_date') ? 'error' : '' }}">
		<label class="control-label" for="start_date">Start Date</label>
		<div class="controls">
			<div id="datetimepicker1" class="input-append date">
				<input type="text" data-format="MM/dd/yyyy hh:mm:ss" name="start_date" id="start_date" value="{{  Input::old('start_date', $channel->start_date ? date("m/d/Y H:i:s", $channel->start_date->sec) : '') }}" />
				<span class="add-on"><i class="icon-calendar"></i></span>

			</div>
			{{ $errors->first('start_date') }}
		</div>
	</div>
	<!-- ./ start_date -->		

	<!-- end_date -->
	<div class="control-group {{ $errors->has('end_date') ? 'error' : '' }}">
		<label class="control-label" for="end_date">End Date</label>
		<div class="controls">
			<div id="datetimepicker2" class="input-append date">
				<input type="text" data-format="MM/dd/yyyy hh:mm:ss" name="end_date" id="end_date" value="{{  Input::old('end_date', $channel->end_date ? date("m/d/Y H:i:s", $channel->end_date->sec) : '') }}" />
				<span class="add-on"><i class="icon-calendar"></i></span>

			</div>
			{{ $errors->first('end_date') }}
		</div>
	</div>
	<!-- ./ end_date -->

	<!-- Update button -->
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-primary">@if ($channel->name) Update @else Save @endif</button>
			<button type="button" onclick="document.location='/channel'" class="btn">Cancel</button>
		</div>
	</div>
	<!-- ./ update button -->
</form>
@endsection
