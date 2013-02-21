@extends('layouts.default')

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
@stop

@section('js')
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-tagmanager.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/slender-parent.js') }}"></script>

<script type="text/javascript">
    $(function(){
        $('.datepicker').datetimepicker();

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
        $("#uploadToYoutube").live('click', function(event){
            event.preventDefault();
            $('#filelist div b').html('0%');
            $('#upload_bar').css('width','0%');
            $('#upload_bar').parent()
                .removeClass('progress-success');
            $("#backToUpload").hide();
            var $this = $(this);
            var path = $(this).attr('rel');
            $.ajax({
                type: 'POST',
                url: '/videoyoutubeupload',
                data: {path: path},
                dataType: "json"
            }).done(function(res) {
                    if (res.source) {
                        $('#source').val(res.source);
                        $('#streaming').val(res.streaming);
                        $('#thumbnail').val(res.thumbnail);

                        $('#upload_bar').parent()
                            .addClass('progress-success');

                        $('#upload_bar').css('width','100%');
                        $('#filelist div b').html('100%');
                    }

                    $this.remove();
                    $("#backToUpload").show();
                }).fail(function() {
                    $('#filelist').append("<div>Error: 500" +
                        ", Message: Youtube connection failed" +
                        "</div>"
                    );

                    $this.remove();
                    $("#backToUpload").show();
                });
        });

        $("#backToUpload").live('click', function(event){
            event.preventDefault();
            $("#uploadToYoutube").remove();
            $(this).remove();
            $('#pickfiles').show();
            $('#filelist').html('');
            $('#upload_bar').css('width','0%');
            $('#upload_bar').parent()
                .removeClass('progress-success');
        });

        var uploader = new plupload.Uploader({
            runtimes : 'html5,browserplus',
            browse_button : 'pickfiles',
            container : 'container',
            max_file_size : '50mb',
            url : '/videoupload',
            filters : [
                //{title : "Video files", extensions : "avi,mpeg,flv,mp4,ogg"}
            ]
            // resize : {width : 320, height : 240, quality : 90}
        });

        uploader.bind('Init', function(up, params) {
            $('#filelist').html("");
        });

        uploader.init();

        uploader.bind('FilesAdded', function(up, files) {
            //console.log(files);
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

        uploader.bind('FileUploaded', function(up, file, response) {
            var resp = $.parseJSON(response.response);
            if (resp.error) {
                var err = resp.error;
                $('#filelist').append("<div>Error: " + err.code +
                    ", Message: " + err.message +
                    (err.file ? ", File: " + err.file.name : "") +
                    "</div>"
                );

                up.refresh();
            }
            else {
                var path = resp.path;
                $('#' + file.id + " b").html("100%");
                $('#upload_bar').parent()
                    .removeClass('active')
                    .addClass('progress-success');

                $('#pickfiles').attr('disabled', false);
                $('#pickfiles').hide();
                var buttonHtml = '<a rel="'+path+'" href="#" class="btn btn-primary" id="uploadToYoutube" style="position: relative; z-index: 0;">Upload To Youtube</a>';
                buttonHtml = buttonHtml + ' <a href="#" class="btn" id="backToUpload" style="position: relative; z-index: 0;">Upload Another File</a>';
                $('#pickfiles').after(buttonHtml);
            }
        });
    });
</script>
@stop

@section('content')
<h2>Edit {{ ucfirst(str_singular($package)) }}</h2>

<form method="{{ $method }}" action="" class="form-horizontal">
    <input type="hidden" name="_method" value="PUT">
    @foreach ($options->fields as $field => $option)
    @if($field == 'urls' || $field == 'availability')
    @foreach ($option as $subfield => $suboption)
    <div class="control-group {{ $errors->has($subfield) ? 'error' : '' }}">
        <label class="control-label" for="{{ $subfield }}">{{ $field }} {{$subfield}}</label>
        <div class="controls">
            @if($suboption->type == 'Date')
            <div class="input-append date datepicker">
                <input type="text" data-format="MM/dd/yyyy hh:mm:ss" name="{{$field}}[{{ $subfield }}]" id="{{ $subfield }}" value="{{ Input::old($subfield, $data->$field->$subfield) }}" />
                <span class="add-on"><i class="icon-calendar"></i></span>
            </div>
            @else
            <input type="text" name="{{$field}}[{{ $subfield }}]" id="{{ $subfield }}" value="{{ Input::old($subfield, $data->$field->$subfield) }}" />
            @endif
            {{{ $errors->first($field) }}}
        </div>
    </div>
    @endforeach
    @else
    <div class="control-group {{ $errors->has($field) ? 'error' : '' }}">
        <label class="control-label" for="{{ $field }}">{{ $field }}</label>
        <div class="controls">

            @if($option->type == 'Date')
            <div class="input-append date datepicker">
                <input type="text" data-format="MM/dd/yyyy hh:mm:ss" name="{{ $field }}" id="{{ $field }}" value="{{ Input::old($field, $data->$field) }}" />
                <span class="add-on"><i class="icon-calendar"></i></span>
            </div>
            @else
            <input type="text" name="{{ $field }}" id="{{ $field }}" value="{{ Input::old($field, $data->$field) }}" />
            @endif

            {{{ $errors->first($field) }}}
        </div>
    </div>
    @endif
    @if($field == 'season')
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
    @endif
    @endforeach

    <!-- Create button -->
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" onclick="document.location='/{{ $package }}'" class="btn">Cancel</button>
        </div>
    </div>
    <!-- ./ Create button -->
</form>
@stop
