@layout('layouts.default')

{{-- Web page Title --}}
@section('title')
@parent
:: Show
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
    <script src="{{ asset('assets/js/slender-parent.js') }}"></script>
	<script>
		$(function(){
			
			jQuery(".tagManager").tagsManager({
		        prefilled: [{{ $show->tags ? "'".implode("', '", (array)$show->tags)."'" : '' }}],
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

            $('.parentHolder').slenderParent();
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
	<h1>@if ($show->title) Show Settings @else New Show @endif</h1>
</div>
<form method="post" action="" class="form-horizontal">
	<!-- show title -->
	<div class="control-group {{ $errors->has('title') ? 'error' : '' }}">
		<label class="control-label" for="title">Title</label>
		<div class="controls">
			<input type="text" name="title" id="title" value="{{  Input::old('title', $show->title) }}" />
			{{ $errors->first('title') }}
		</div>
	</div>
	<!-- ./ show title -->


	<!-- show Description -->
	<div class="control-group {{ $errors->has('description') ? 'error' : '' }}">
		<label class="control-label" for="description">Description</label>
		<div class="controls">
			<textarea name="description" id="description" class="input-xxlarge" rows="3">{{  Input::old('description', $show->description) }}</textarea>
			{{ $errors->first('description') }}
		</div>
	</div>
	<!-- ./ show Description -->


	<!-- show slug -->
	<div class="control-group {{ $errors->has('slug') ? 'error' : '' }}">
		<label class="control-label" for="slug">Slug</label>
		<div class="controls">
			<input type="text" name="slug" id="slug" value="{{  Input::old('slug', $show->slug) }}" />
			{{ $errors->first('slug') }}
		</div>
	</div>
	<!-- ./ show slug -->

	<!-- show tags -->
	<div class="control-group {{ $errors->has('tags') ? 'error' : '' }}">
		<label class="control-label" for="tags">Tags</label>
		<div class="controls">
			<input type="text" id="tags" name="_tags" placeholder="Tags" class="tagManager" value="{{  Input::old('tags', $show->tags) }}" />
			{{ $errors->first('tags') }}
		</div>
	</div>
	<!-- ./ show tags -->

	<!-- show genre -->
	<div class="control-group {{ $errors->has('genre') ? 'error' : '' }}">
		<label class="control-label" for="genre">Genre</label>
		<div class="controls">
			<input type="text" name="genre" id="genre" autocomplete="off" class="typeahead" value="{{  Input::old('genre', $show->genre) }}" />
			{{ $errors->first('genre') }}
		</div>
	</div>
	<!-- ./ show genre -->
	
	<!-- show parent -->
	<div class="control-group {{ $errors->has('parent') ? 'error' : '' }} parentHolder">
		<label class="control-label" for="tags">Parent</label>
		<div class="controls">
			<input type="hidden" name="parent_id" value="{{  Input::old('parent_id', isset($show->parent['id']) ? $show->parent['id'] : '' ) }}" />
			<input type="hidden" name="parent_type" value="{{  Input::old('parent_type', isset($show->parent['type']) ? $show->parent['type'] : '') }}" />
				<span id='parent_value'>
					@if ($parent) 
						{{ $show->parent['type']}}: {{ $parent->title }} 
					@endif
				</span>
			<a href="#" id="parent_remove" class="btn btn-danger btn-small @if (!$parent) hide@endif"><i class='icon-remove-sign'></i> Remove</a>
			<!-- Button to trigger modal -->
			<a href="#myModal" role="button" class="btn btn-info btn-small" data-toggle="modal"><i class='icon-magnet'></i> Assign</a>


			<!-- Modal -->
			<div id="myModal" class="modal hide fade" style="heigth:200px" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			    <h3 id="myModalLabel">Parent for show</h3>
			  </div>
			  <div class="modal-body" style="height: 160px;">

			  	<div class="control-group">
					<label class="control-label" for="tags">Type:</label>
					<div class="controls">
					    <select id='parent_type'>
					    		<option  selected="selected"  disabled="disabled">Select Type</option>
					    	@foreach ($show->getParents() as $parent)
						  		<option>{{ $parent }}</option>
						  	@endforeach
						</select>
					
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="tags">Parent:</label>
					<div class="controls">
					    <select id='parent_id'>
					    		<option  selected="selected"  disabled="disabled">Select</option>
						</select>
						
					</div>
				</div>
				<div class="alert alert-error hide" id='parent_error'>
				  Please select Type and Parent!
				</div>
			  </div>
			  <div class="modal-footer">
			    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			    <button class="btn btn-primary" id='select_parent'>Save changes</button>
			  </div>
			</div>

			{{ $errors->first('parent') }}
		</div>
	</div>
	<!-- ./ show parent -->


	<!-- start_date -->
	<div class="control-group {{ $errors->has('start_date') ? 'error' : '' }}">
		<label class="control-label" for="start_date">Start Date</label>
		<div class="controls">
			<div id="datetimepicker1" class="input-append date">
				<input type="text" data-format="MM/dd/yyyy hh:mm:ss" name="start_date" id="start_date" value="{{  Input::old('start_date', $show->start_date ? date("m/d/Y H:i:s", $show->start_date->sec) : '') }}" />
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
				<input type="text" data-format="MM/dd/yyyy hh:mm:ss" name="end_date" id="end_date" value="{{  Input::old('end_date', $show->end_date ? date("m/d/Y H:i:s", $show->end_date->sec) : '') }}" />
				<span class="add-on"><i class="icon-calendar"></i></span>

			</div>
			{{ $errors->first('end_date') }}
		</div>
	</div>
	<!-- ./ end_date -->

	<!-- Update button -->
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-primary">@if ($show->name) Update @else Save @endif</button>
			<button type="button" onclick="document.location='/show'" class="btn">Cancel</button>
		</div>
	</div>
	<!-- ./ update button -->
</form>
@endsection
