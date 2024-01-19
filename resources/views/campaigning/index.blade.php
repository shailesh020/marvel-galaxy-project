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
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Note</th>
                    <th>Image/Gif</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $campaigning)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $campaigning->name }}</td>
                        <td>{{ dateFormat($campaigning->start_date) }}</td>
                        <td>{{ dateFormat($campaigning->end_date) }}</td>
                        <td>{{ $campaigning->note }}</td>
                        <td>
                            <img src="{{asset("file/$title/$campaigning->photo")}}" alt="" height="100px">
                        </td>
                        <td>
                            <a class="btn btn-info btn-sm" href="{{ route("$title.show", $campaigning->id) }}">Show</a>
                            <a class="btn btn-primary btn-sm" href="{{ route("$title.edit", $campaigning->id) }}">Edit</a>
                            {!! Form::open(['method' => 'DELETE', 'route' => ["$title.destroy", $campaigning->id], 'style' => 'display:inline']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                            @if ($campaigning->photo)
                                <a target="_blank" class="btn btn-warning btn-sm" href='{{asset("file/$title/$campaigning->photo")}}'>File</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
