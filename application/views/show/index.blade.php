@layout('layouts.default')

{{-- Web page Title --}}
@section('title')
@parent
:: Shows
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
	<h1>Shows</h1>

@if($shows)

	<table class="table table-striped table-hover table-bordered">
		<thead>
	        <tr>
	          <th>Title</th>
	          <th>Slug</th>
	          <th>Genre</th>

			@if (Auth::user()->has_access("show.edit"))
	          <th style="text-align: center;"><button class="btn btn-mini btn-success" onclick="document.location='show/edit'" type="button">New</button></th>
			@endif
	        </tr>
	      </thead>
         <tbody>
        	@foreach ($shows as $id => $show)
                <tr>
                  <td>{{ $show->title }}</td>
                  <td>{{ $show->slug }}</td>
                  <td>{{ $show->genre }}</td>
                  
                  @if (Auth::user()->has_access("show.edit"))
                  	<td style="text-align: center;"><button class="btn btn-mini btn-primary" onclick="document.location='show/edit/{{ $id }}'" type="button">edit</button></td>
                  @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@else
	<div class="alert">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>Warning!</strong> No Shows Found!
		@if (Auth::user()->has_access("show.edit"))
			<hr/>
			<button class="btn btn-success" onclick="document.location='show/edit'" type="button">Create New Show</button>
		@endif
	</div>
@endif
</div>


@endsection
