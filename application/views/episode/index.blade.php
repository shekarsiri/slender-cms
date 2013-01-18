@layout('layouts.default')

{{-- Web page Title --}}
@section('title')
@parent
:: Episodes
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
	<h1>Episodes</h1>

@if($episodes)

	<table class="table table-striped table-hover table-bordered">
		<thead>
	        <tr>
	          <th>Title</th>
	          <th>Slug</th>
	          <th>Genre</th>

			@if (Auth::user()->has_access("episode.edit"))
	          <th style="text-align: center;"><button class="btn btn-mini btn-success" onclick="document.location='episode/edit'" type="button">New</button></th>
			@endif
	        </tr>
	      </thead>
         <tbody>
        	@foreach ($episodes as $id => $episode)
                <tr>
                  <td>{{ $episode->title }}</td>
                  <td>{{ $episode->slug }}</td>
                  <td>{{ $episode->genre }}</td>
                  
                  @if (Auth::user()->has_access("episode.edit"))
                  	<td style="text-align: center;"><button class="btn btn-mini btn-primary" onclick="document.location='episode/edit/{{ $id }}'" type="button">edit</button></td>
                  @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@else
	<div class="alert">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>Warning!</strong> No Episodes Found!
		@if (Auth::user()->has_access("episode.edit"))
			<hr/>
			<button class="btn btn-success" onclick="document.location='episode/edit'" type="button">Create New Episode</button>
		@endif
	</div>
@endif
</div>


@endsection
