@extends('layouts.default')

@section('content')
<div class="page-header">
    <h1>Roles</h1>
    <button class="btn-primary" onclick="document.location='roles/create'" type="button">Add New Role</button><br/>
    <table class="table table-striped table-hover table-bordered">
        <tbody>
        @foreach ($roles as $id => $role)
        <tr>
        <td><a href="roles/{{ $role->_id }}">{{ $role->name }} </a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop