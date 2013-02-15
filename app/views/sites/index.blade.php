@extends('layouts.default')

@section('content')
<div class="page-header">
    <h1>Sites</h1>

    <table class="table table-striped table-hover table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($sites as $id => $site)
        <tr>
        <td>{{ $site->_id }}</td>
        <td>{{ $site->name }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop