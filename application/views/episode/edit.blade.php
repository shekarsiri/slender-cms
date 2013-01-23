@layout('layouts.default')

{{-- Web page Title --}}
@section('title')
@parent
:: Episode
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
    <script src="{{ asset('assets/js/slender-season.js') }}"></script>
    <script src="{{ asset('assets/js/slender-parent.js') }}"></script>
	<script>
		$(function(){
			
			jQuery(".tagManager").tagsManager({
		        prefilled: [{{ $episode->tags ? "'".implode("', '", (array)$episode->tags)."'" : '' }}],
		        preventSubmitOnEnter: true,
		        typeahead: true,
		        typeaheadAjaxSource: null,
		        blinkBGColor_1: '#FFFF9C',
		        blinkBGColor_2: '#CDE69C',
		        hiddenTagListName: 'tags'
		      });

            $('#season').slenderSeason({
                showId: '50f9508a7c69dae109000000'
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
	<h1>@if ($episode->title) Episode Settings @else New Episode @endif</h1>
</div>
<form method="post" action="" class="form-horizontal">
	<!-- episode title -->
	<div class="control-group {{ $errors->has('title') ? 'error' : '' }}">
		<label class="control-label" for="title">Title</label>
		<div class="controls">
			<input type="text" name="title" id="title" value="{{  Input::old('title', $episode->title) }}" />
			{{ $errors->first('title') }}
		</div>
	</div>
	<!-- ./ episode title -->


	<!-- episode Description -->
	<div class="control-group {{ $errors->has('description') ? 'error' : '' }}">
		<label class="control-label" for="description">Description</label>
		<div class="controls">
			<textarea name="description" id="description" class="input-xxlarge" rows="3">{{  Input::old('description', $episode->description) }}</textarea>
			{{ $errors->first('description') }}
		</div>
	</div>
	<!-- ./ episode Description -->


	<!-- episode slug -->
	<div class="control-group {{ $errors->has('slug') ? 'error' : '' }}">
		<label class="control-label" for="slug">Slug</label>
		<div class="controls">
			<input type="text" name="slug" id="slug" value="{{  Input::old('slug', $episode->slug) }}" />
			{{ $errors->first('slug') }}
		</div>
	</div>
	<!-- ./ episode slug -->

	<!-- episode tags -->
	<div class="control-group {{ $errors->has('tags') ? 'error' : '' }}">
		<label class="control-label" for="tags">Tags</label>
		<div class="controls">
			<input type="text" id="tags" name="_tags" placeholder="Tags" class="tagManager" value="{{  Input::old('tags', $episode->tags) }}" />
			{{ $errors->first('tags') }}
		</div>
	</div>
	<!-- ./ episode tags -->
	
	<!-- episode parent -->
	<div class="control-group {{ $errors->has('parent') ? 'error' : '' }} parentHolder">
		<label class="control-label" for="tags">Parent</label>
		<div class="controls">
			<input type="hidden" name="parent_id" value="{{  Input::old('parent_id', isset($episode->parent['id']) ? $episode->parent['id'] : '' ) }}" />
			<input type="hidden" name="parent_type" value="{{  Input::old('parent_type', isset($episode->parent['type']) ? $episode->parent['type'] : '') }}" />
				<span id='parent_value'>
					@if ($parent) 
						{{ $episode->parent['type']}}: {{ $parent->title }}
					@endif
				</span>
			<a href="#" id="parent_remove" class="btn btn-danger btn-small @if (!$parent) hide@endif"><i class='icon-remove-sign'></i> Remove</a>
			<!-- Button to trigger modal -->
			<a href="#myModal" role="button" class="btn btn-info btn-small" data-toggle="modal"><i class='icon-magnet'></i> Assign</a>


			<!-- Modal -->
			<div id="myModal" class="modal hide fade" style="heigth:200px" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			    <h3 id="myModalLabel">Parent for episode</h3>
			  </div>
			  <div class="modal-body" style="height: 160px;">

			  	<div class="control-group">
					<label class="control-label" for="tags">Type:</label>
					<div class="controls">
					    <select id='parent_type'>
					    		<option  selected="selected"  disabled="disabled">Select Type</option>
					    	@foreach ($episode->getParents() as $parent)
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
	<!-- ./ episode parent -->

    <!-- episode season -->
    <div class="control-group {{ $errors->has('season') ? 'error' : '' }}">
        <label class="control-label" for="season">Season</label>
        <div class="controls">
            <input type="text" name="season" id="season" autocomplete="off" class="typeahead season" value="{{  Input::old('season', $episode->season) }}" />
            {{ $errors->first('season') }}
        </div>
    </div>
    <!-- ./ episode season -->

	<!-- Update button -->
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-primary">@if ($episode->name) Update @else Save @endif</button>
			<button type="button" onclick="document.location='/episode'" class="btn">Cancel</button>
		</div>
	</div>
	<!-- ./ update button -->
</form>
@endsection
