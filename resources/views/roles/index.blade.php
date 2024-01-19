@extends('layouts.app')
@section('page-title', 'Roles')
@section('content')
    <div class="row mb-2">
        <div class="col-md-6 d-flex justify-content-start">
            <h2>Role Management</h2>
        </div>
        <div class="col-md-6 d-flex  justify-content-end">
            <a class="btn btn-success" href="{{ route('roles.create') }}"><i class="fa fa-plus" aria-hidden="true"></i></a>
        </div>
    </div>

    <x-alert-pop-up />

    <div class="card">
        <table class="table table-bordered m-0">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Permissions</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($roles as $key => $role)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        @foreach ($role->permissions as $item)
                            <label class="badge badge-success">{{ $item->name }}</label>
                        @endforeach
                    </td>
                    <td>
                        <a class="btn btn-info" href="{{ route('roles.show', $role->id) }}">Show</a>
                        @can('role-edit')
                            <a class="btn btn-primary" href="{{ route('roles.edit', $role->id) }}">Edit</a>
                        @endcan
                        @can('role-delete')
                            {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'style' => 'display:inline']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        @endcan
                    </td>
                </tr>
            @endforeach
        </table>
        <hr>
        <div class="row">
            <div class="col-md-5 d-flex justify-content-start mt-3 ml-3">
                Viewing {{ $roles->firstItem() }} - {{ $roles->lastItem() }} of {{ $roles->total() }} entries
            </div>
            <div class="col-md-6 d-flex justify-content-end mt-3">
                {!! $roles->render() !!}
            </div>
        </div>
    </div>
@endsection
