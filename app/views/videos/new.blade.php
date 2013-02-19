@extends('layouts.default')

@section('js')
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-tagmanager.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/slender-parent.js') }}"></script>

<script type="text/javascript">
    $(function(){
        alert('asd');
        //$('#sunrise').DateTimePicker();


        $('#genre').typeahead({
            source: [
                @foreach (Config::get('app.genres') as $genre)
                "{{ $genre }}",
                @endforeach
            ]
        });
    });
</script>
<script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
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
@stop

{{-- Content --}}
@section('content')
<h2>New {{ ucfirst(str_singular($package)) }}</h2>
<form method="{{ $method }}" action="/{{ $package }}" class="form-horizontal">

    @foreach ($options->fields as $field => $option)
        @if($field == 'urls' || $field == 'availability')
            @foreach ($option as $subfield => $suboption)
                <div class="control-group {{ $errors->has($subfield) ? 'error' : '' }}">
                    <label class="control-label" for="{{ $subfield }}">{{ $field }} {{$subfield}}</label>
                    <div class="controls">
                        <input type="text"
                        @if($suboption->type == 'DateTime')
                            class="datepicker"
                        @endif
                               name="{{$field}}_{{ $subfield }}" id="{{ $subfield }}" value="" />
                        {{{ $errors->first($field) }}}
                    </div>
                </div>
            @endforeach
        @else
            <div class="control-group {{ $errors->has($field) ? 'error' : '' }}">
                <label class="control-label" for="{{ $field }}">{{ $field }}</label>
                <div class="controls">
                    <input type="text"
                    @if($option->type == 'DateTime')
                    class="datepicker"
                    @endif
                           name="{{ $field }}" id="{{ $field }}" value="" />
                    {{{ $errors->first($field) }}}
                </div>
            </div>
        @endif
    @endforeach

    <!-- Create button -->
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-primary">Create</button>
            <button type="button" onclick="document.location='/{{ $package }}'" class="btn">Cancel</button>
        </div>
    </div>
    <!-- ./ Create button -->
</form>
@stop
