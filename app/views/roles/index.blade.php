@extends('layouts.default')

@section('content')
<div class="page-header">
    <h1>Roles</h1>
    <table class="table table-striped table-hover table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th><a href='/roles/create' class="btn btn-mini btn-success">Create New</a></th>
                
            </tr>
        </thead>
        <tbody>
        <tbody>
            @foreach ($roles as $id => $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td style='width:100px'>
                    <div class="btn-group">
                      <a href='/roles/{{ $role->_id }}/delete' class="btn btn-mini btn-danger">Delete</a>
                      <a href='/roles/{{ $role->_id }}' class="btn btn-mini btn-primary">Edit</a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop
