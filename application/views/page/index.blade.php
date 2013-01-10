@layout('layouts.default')

{{-- Web page Title --}}
@section('title')
@parent
:: Pages
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
	<h1>Pages</h1>

@if($pages)

	<table class="table table-striped table-hover table-bordered">
		<thead>
	        <tr>
	          <th>Title</th>
	          <th>Url</th>
	          <th>Slug</th>
			@if (Auth::user()->has_access("page.edit"))
	          <th style="text-align: center;"><button class="btn btn-mini btn-success" onclick="document.location='page/edit'" type="button">New</button></th>
			@endif
	        </tr>
	      </thead>
         <tbody>
        	@foreach ($pages as $id => $page)
                <tr>
                  <td>{{ $page->title }}</td>
                  <td>{{ $page->url }}</td>
                  <td>{{ $page->slug }}</td>
                  @if (Auth::user()->has_access("page.edit"))
                  	<td style="text-align: center;"><button class="btn btn-mini btn-primary" onclick="document.location='page/edit/{{ $id }}'" type="button">edit</button></td>
                  @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@else
	<div class="alert">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>Warning!</strong> No Pages Found!
		@if (Auth::user()->has_access("page.edit"))
			<hr/>
			<button class="btn btn-success" onclick="document.location='page/edit'" type="button">Create New Page</button>
		@endif
	</div>
@endif
</div>


@endsection
