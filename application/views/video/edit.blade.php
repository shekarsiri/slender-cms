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
	
	<!-- fineuploader plugin -->
	<link href="{{ asset('assets/css/fineuploader.css') }}" rel="stylesheet">
	<style>
      /* Fine Uploader
      -------------------------------------------------- */
      .qq-upload-list {
        text-align: left;
      }
 
      /* For the bootstrapped demos */
      li.alert-success {
        background-color: #DFF0D8;
      }
 
      li.alert-error {
        background-color: #F2DEDE;
      }
 
      .alert-error .qq-upload-failed-text {
        display: inline;
      }
    </style>
@endsection

@section('js')
	<!-- jQuery tag plugin -->
	<script src="{{ asset('assets/js/bootstrap-tagmanager.js') }}"></script>

	<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/slender-parent.js') }}"></script>
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
		    $('#datetimepicker2').datetimepicker();
			$('#datetimepicker3').datetimepicker();


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

	<script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
	
	<!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->
	<script type="text/javascript" src="{{ asset('assets/js/plupload.full.js') }}"></script>

	<script type="text/javascript">
	// Custom example logic
	$(function() {
		var uploader = new plupload.Uploader({
			runtimes : 'html5,browserplus',
			browse_button : 'pickfiles',
			container : 'container',
			// max_file_size : '10mb',
			url : '/video/upload',
			// filters : [
			// 	{title : "Image files", extensions : "jpg,gif,png"},
			// 	{title : "Zip files", extensions : "zip"}
			// ],
			// resize : {width : 320, height : 240, quality : 90}
		});

		uploader.bind('Init', function(up, params) {
			$('#filelist').html("");
		});

		uploader.init();

		uploader.bind('FilesAdded', function(up, files) {
			$.each(files, function(i, file) {
				$('#filelist').append(
					'<div id="' + file.id + '">' +
					file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
				'</div>');
			});

			up.refresh(); // Reposition Flash/Silverlight

			uploader.start();
			$('#pickfiles').attr('disabled', true);
			$('#upload_bar').parent()
					.removeClass('progress-success')
					.addClass('active');
		});

		uploader.bind('UploadProgress', function(up, file) {
			$('#upload_bar').parent().show()
			$('#upload_bar').css('width', file.percent + "%");
			$('#' + file.id + " b").html(file.percent + "%");
		});

		uploader.bind('Error', function(up, err) {
			$('#filelist').append("<div>Error: " + err.code +
				", Message: " + err.message +
				(err.file ? ", File: " + err.file.name : "") +
				"</div>"
			);

			up.refresh(); // Reposition Flash/Silverlight
		});

		uploader.bind('FileUploaded', function(up, file) {
			$('#' + file.id + " b").html("100%");
			$('#upload_bar').parent()
					.removeClass('active')
					.addClass('progress-success');

			$('#pickfiles').attr('disabled', false);
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
				<span class="add-on"><i class="icon-calendar"></i></span>

			</div>
			{{ $errors->first('premiere_date') }}
		</div>
	</div>
	<!-- ./ video premiere date -->	



	<!-- video parent -->
	<div class="control-group {{ $errors->has('parent') ? 'error' : '' }} parentHolder">
		<label class="control-label" for="tags">Parent</label>
		<div class="controls">
			<input type="hidden" name="parent_id" value="{{  Input::old('parent_id', isset($video->parent['id']) ? $video->parent['id'] : '' ) }}" />
			<input type="hidden" name="parent_type" value="{{  Input::old('parent_type', isset($video->parent['type']) ? $video->parent['type'] : '') }}" />
				<span id='parent_value'>
					@if ($parent) 
						{{ $video->parent['type']}}: {{ $parent->title }} 
					@endif
				</span>
			<a href="#" id="parent_remove" class="btn btn-danger btn-small @if (!$parent) hide@endif"><i class='icon-remove-sign'></i> Remove</a>
			<!-- Button to trigger modal -->
			<a href="#myModal" role="button" class="btn btn-info btn-small" data-toggle="modal"><i class='icon-magnet'></i> Assign</a>


			<!-- Modal -->
			<div id="myModal" class="modal hide fade" style="heigth:200px" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			    <h3 id="myModalLabel">Parent for video</h3>
			  </div>
			  <div class="modal-body" style="height: 160px;">

			  	<div class="control-group">
					<label class="control-label" for="tags">Type:</label>
					<div class="controls">
					    <select id='parent_type'>
					    		<option  selected="selected"  disabled="disabled">Select Type</option>
					    	@foreach ($video->getParents() as $parent)
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
	<!-- ./ video parent -->

	
 



	<!-- video genre -->
	<div class="control-group {{ $errors->has('genre') ? 'error' : '' }}">
		<label class="control-label" for="genre">Genre</label>
		<div class="controls">
			<input type="text" name="genre" id="genre" autocomplete="off" class="typeahead" value="{{  Input::old('genre', $video->genre) }}" />
			{{ $errors->first('genre') }}
		</div>
	</div>
	<!-- ./ video genre -->


	<!-- uploader -->
	<div class="control-group">
		<label class="control-label" for="urls_source">Video Uploader</label>
		<div class="controls">			
			
			<div id="container">
			    <div id="filelist">No runtime found.</div>
			    <div class="progress progress-striped active hide">
				  <div class="bar" id="upload_bar" style="width: 0%;"></div>
				</div>
			    <a id="pickfiles" class="btn btn-primary" href="#">Select file</a>
			</div>


		</div>
	</div>
	<!-- ./ uploader -->

	<!-- urls.source -->
	<div class="control-group {{ $errors->has('urls_source') ? 'error' : '' }}">
		<label class="control-label" for="urls_source">URLs Source</label>
		<div class="controls">
			<input type="text" name="urls_source" id="urls_source" value="{{  Input::old('urls_source', isset($video->urls['source']) && $video->urls['source'] ? $video->urls['source'] : '') }}" />
			{{ $errors->first('urls_source') }}
		</div>
	</div>
	<!-- ./ urls.source -->

	<!-- urls.streaming -->
	<div class="control-group {{ $errors->has('urls_streaming') ? 'error' : '' }}">
		<label class="control-label" for="urls_streaming">URLs Streaming</label>
		<div class="controls">
			<input type="text" name="urls_streaming" id="urls_streaming" value="{{  Input::old('urls_streaming', isset($video->urls['streaming']) && $video->urls['streaming'] ? $video->urls['streaming'] : '') }}" />

			{{ $errors->first('urls_streaming') }}
		</div>
	</div>
	<!-- ./ urls.streaming -->

	<!-- urls.thumbnail -->
	<div class="control-group {{ $errors->has('urls_thumbnail') ? 'error' : '' }}">
		<label class="control-label" for="urls_thumbnail">URLs Thumbnail</label>
		<div class="controls">
			<input type="text" name="urls_thumbnail" id="urls_thumbnail" value="{{  Input::old('urls_thumbnail', isset($video->urls['thumbnail']) && $video->urls['thumbnail'] ? $video->urls['thumbnail'] : '') }}" />

			{{ $errors->first('urls_thumbnail') }}
		</div>
	</div>
	<!-- ./ urls.thumbnail -->	

	<!-- availability.sunrise -->
	<div class="control-group {{ $errors->has('availability_sunrise') ? 'error' : '' }}">
		<label class="control-label" for="availability_sunrise">Sunrise</label>
		<div class="controls">
			<div id="datetimepicker3" class="input-append date">
				<input type="text" data-format="MM/dd/yyyy hh:mm:ss" name="availability_sunrise" id="availability_sunrise" value="{{  Input::old('availability_sunrise', isset($video->availability['sunrise']) && $video->availability['sunrise'] ? date("m/d/Y H:i:s", $video->availability['sunrise']->sec) : '') }}" />
				<span class="add-on"><i class="icon-calendar"></i></span>

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
				<input type="text" data-format="MM/dd/yyyy hh:mm:ss" name="availability_sunset" id="availability_sunset" value="{{  Input::old('availability_sunset', isset($video->availability['sunset']) && $video->availability['sunset'] ? date("m/d/Y H:i:s", $video->availability['sunset']->sec) : '') }}" />
				<span class="add-on"><i class="icon-calendar"></i></span>

			</div>
			{{ $errors->first('availability_sunset') }}
		</div>
	</div>
	<!-- ./ availability.sunset -->

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
