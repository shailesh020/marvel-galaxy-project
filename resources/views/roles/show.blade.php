@extends('layouts.app')
@section('page-title', 'Show-Role')
@section('content')
    <div class="row mb-2">
        <div class="col-md-6 d-flex justify-content-start">
            <h2>Show Role</h2>
        </div>
        <div class="col-md-6 d-flex  justify-content-end">
            <a class="btn btn-primary" href="{{ route('roles.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        </div>
    </div>
    <div class="card p-3">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    {{ $role->name }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Permissions:</strong>
                    @if (!empty($rolePermissions))
                        @foreach ($rolePermissions as $v)
                            <label class="badge badge-success">{{ $v->name }}</label>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
