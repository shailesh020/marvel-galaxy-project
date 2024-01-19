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
                    <th>Bill Number</th>
                    <th>Client Name</th>
                    <th>Client Mobile Number</th>
                    <th>Machine Name</th>
                    <th>Date Of Purchase</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $purchase)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $purchase->bill_no }}</td>
                        <td>{{ $purchase->client->name }}</td>
                        <td>{{ $purchase->client->phone_no }}</td>
                        <td>{{ $purchase->machine->name }}</td>
                        <td>{{ dateFormat($purchase->purchase_date) }}</td>
                        <td>
                            <a class="btn btn-info btn-sm" href="{{ route("$title.show", $purchase->id) }}">Show</a>
                            <a class="btn btn-primary btn-sm" href="{{ route("$title.edit", $purchase->id) }}">Edit</a>
                            {!! Form::open(['method' => 'DELETE', 'route' => ["$title.destroy", $purchase->id], 'style' => 'display:inline']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                            @if ($purchase->photo)
                                <a target="_blank" class="btn btn-warning btn-sm" href='{{asset("file/$title/$purchase->photo")}}'>File</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
