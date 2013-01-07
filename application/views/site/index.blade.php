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
</div>
{{ var_dump($sites) }}
@endsection
