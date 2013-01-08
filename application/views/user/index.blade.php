@layout('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
:: Account
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
	<h1>Users</h1>

	<table class="table table-striped table-hover table-bordered">
		<thead>
	        <tr>
	          <th>Name</th>
	          <th>Email</th>
	          <th></th>
	        </tr>
	      </thead>
         <tbody>
        	@foreach ($users as $id => $user)
                <tr @if ($user->has_access("user.view")) class="success" @endif >
                  <td>{{ $user->fullName() }}</td>
                  <td>{{ $user->email }}</td>
                  <td style="text-align: center;"><button class="btn btn-mini btn-primary" onclick="document.location='user/edit/{{ $id }}'" type="button">edit</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
