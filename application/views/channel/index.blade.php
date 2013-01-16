@layout('layouts.default')

{{-- Web page Title --}}
@section('title')
@parent
:: Channels
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
	<h1>Channels</h1>

@if($channels)

	<table class="table table-striped table-hover table-bordered">
		<thead>
	        <tr>
	          <th>Title</th>
	          <th>Slug</th>
	          <th>Genre</th>

			@if (Auth::user()->has_access("channel.edit"))
	          <th style="text-align: center;"><button class="btn btn-mini btn-success" onclick="document.location='channel/edit'" type="button">New</button></th>
			@endif
	        </tr>
	      </thead>
         <tbody>
        	@foreach ($channels as $id => $channel)
                <tr>
                  <td>{{ $channel->title }}</td>
                  <td>{{ $channel->slug }}</td>
                  <td>{{ $channel->genre }}</td>
                  
                  @if (Auth::user()->has_access("channel.edit"))
                  	<td style="text-align: center;"><button class="btn btn-mini btn-primary" onclick="document.location='channel/edit/{{ $id }}'" type="button">edit</button></td>
                  @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@else
	<div class="alert">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>Warning!</strong> No Channels Found!
		@if (Auth::user()->has_access("channel.edit"))
			<hr/>
			<button class="btn btn-success" onclick="document.location='channel/edit'" type="button">Create New Channel</button>
		@endif
	</div>
@endif
</div>


@endsection
