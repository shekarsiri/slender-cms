@layout('layouts.default')

{{-- Web page Title --}}
@section('title')
@parent
:: Videos
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
	<h1>Video</h1>

@if($videos)

	<table class="table table-striped table-hover table-bordered">
		<thead>
	        <tr>
	          <th>Title</th>
	          <!-- <th>Url</th> -->
	          <th>Slug</th>
	          <th>Premiere Date</th>

			@if (Auth::user()->has_access("video.edit"))
	          <th style="text-align: center;"><button class="btn btn-mini btn-success" onclick="document.location='video/edit'" type="button">New</button></th>
			@endif
	        </tr>
	      </thead>
         <tbody>
        	@foreach ($videos as $id => $video)
                <tr>
                  <td>{{ $video->title }}</td>
                  <!-- <td>{{ $video->url }}</td> -->
                  <td>{{ $video->slug }}</td>
                  <td>{{ $video->premiere_date ? date("m/d/Y H:i:s",$video->premiere_date->sec) : '' }}</td>
                  
                  @if (Auth::user()->has_access("video.edit"))
                  	<td style="text-align: center;"><button class="btn btn-mini btn-primary" onclick="document.location='video/edit/{{ $id }}'" type="button">edit</button></td>
                  @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@else
	<div class="alert">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>Warning!</strong> No Videos Found!
		@if (Auth::user()->has_access("video.edit"))
			<hr/>
			<button class="btn btn-success" onclick="document.location='video/edit'" type="button">Create New Video</button>
		@endif
	</div>
@endif
</div>


@endsection
