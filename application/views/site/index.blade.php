@layout('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
:: Sites
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
	<h1>Sites</h1>
@if ($sites)
	<table class="table table-striped table-hover table-bordered">
		<thead>
	        <tr>
	          <th>Name</th>
	          <th>Url</th>

			@if (Auth::user()->has_access("site.edit"))
	          <th style="text-align: center;"><button class="btn btn-mini btn-success" onclick="document.location='site/edit'" type="button">New</button></th>
			@endif
	        </tr>
	      </thead>
         <tbody>
        	@foreach ($sites as $id => $site)
                <tr>
                  <td>{{ $site->name }}</td>
                  <td>{{ $site->url }}</td>
                  @if (Auth::user()->has_access("site.edit"))
                  	<td style="text-align: center;"><button class="btn btn-mini btn-primary" onclick="document.location='site/edit/{{ $id }}'" type="button">edit</button></td>
                  @endif
                </tr>
            @endforeach
        </tbody>
    </table>

@else
	<div class="alert">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>Warning!</strong> No Sites Found!
		@if (Auth::user()->has_access("site.edit"))
			<hr/>
			<button class="btn btn-success" onclick="document.location='site/edit'" type="button">Create New Site</button>
		@endif
	</div>
@endif
</div>


@endsection
