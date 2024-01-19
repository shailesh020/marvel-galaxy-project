@extends('layouts.app')
@section('page-title', ucfirst($title))
@section('content')
    <div class="row mb-2 align-items-center">
        <div class="col-md-6 d-flex justify-content-start">
            <h3>{{ucfirst($title)}} Management</h3>
        </div>
        <div class="col-md-6 d-flex  justify-content-end">
            @can('user-create')
                <div>
                    <a class="btn btn-success btn-sm" href="{{ route("$title.create") }}"><i class="fa fa-plus" aria-hidden="true"></i> Add {{ucfirst($title)}}</a>
                </div>
            @endcan
        </div>
    </div>

    <x-alert-pop-up />

    <div class="card p-2 table-responsive">
        <table class="table table-bordered m-0" id="dtBasicExample">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Mobile No.</th>
                    <th>Email</th>
                    <th>{{$title == 'clients' ? 'Office Address' : 'Residential Address' }}</th>
                    @if ($title == 'clients')
                        <th>No. Of Machine</th>
                    @endif
                    @canany(['user-list', 'user-edit', 'user-delete'])
                        <th width="280px">Action</th>
                    @endcanany
                </tr>
            </thead>
            <tbody>
              
                @foreach ($data as $key => $user)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->phone_no }} <br/> {{$user->alternet_phone_no}}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $title == 'clients' ? $user->office_address : $user->residential_address}}</td>
                        @if ($title == 'clients')
                        <td>
                            @if ($user->PurchaseMachine->count() > 0)
                                <a class="btn btn-warning btn-sm" href="{{ route("purchase.show", $user->PurchaseMachine->first()->id) }}">{{$user->PurchaseMachine->count()}}</a>
                            @endif
                        </td>
                        @endif
                        @canany(['user-list', 'user-edit', 'user-delete'])
                            <td>
                                @can('user-list')
                                    <a class="btn btn-info btn-sm" href="{{ route("$title.show", $user->id) }}">Show</a>
                                @endcan
                                @can('user-edit')
                                    <a class="btn btn-primary btn-sm" href="{{ route("$title.edit", $user->id) }}">Edit</a>
                                @endcan
                                @can('user-delete')
                                    {!! Form::open(['method' => 'DELETE', 'route' => ["$title.destroy", $user->id], 'style' => 'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                    {!! Form::close() !!}
                                @endcan
                                @if ($title != 'clients' && $user->file)
                                    <a target="_blank" class="btn btn-warning btn-sm" href='{{asset("file/engineers/$user->file")}}'>File</a>
                                @endif
                            </td>
                        @endcanany
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
