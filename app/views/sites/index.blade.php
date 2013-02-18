@extends('layouts.default')

@section('content')
<div class="page-header">
    <h1>Sites</h1>

    <table class="table table-striped table-hover table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th><a href='/sites/create' class="btn btn-mini btn-success">Create New</a></th>
            
        </tr>
        </thead>
        <tbody>
        @foreach ($sites as $id => $site)
        <tr>
        <td>{{ $site->title }}</td>
        <td class="text-center" style='width:100px'>
            <div class="btn-group">
              <a href='/sites/{{ $site->_id }}/delete' class="btn btn-mini btn-danger">Delete</a>
              <a href='/sites/{{ $site->_id }}' class="btn btn-mini btn-primary">Edit</a>
            </div>
        </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
