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
		<label class="control-label" for="title">Video Title</label>
		<div class="controls">
			<input type="text" name="title" id="title" value="{{  Input::old('title', $video->title) }}" />
			{{ $errors->first('title') }}
		</div>
	</div>
	<!-- ./ video title -->


	
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
