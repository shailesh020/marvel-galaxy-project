@extends('layouts.app')
@section('page-title', 'Show-'.ucfirst($title))
@section('content')
    <div class="row mb-2 align-items-center">
        <div class="col-md-6 d-flex justify-content-start">
            <h3>Show {{ucfirst($title)}}</h3>
        </div>
        <div class="col-md-6 d-flex  justify-content-end">
            <div>
                <a class="btn btn-primary btn-sm" href="{{ route("$title.index") }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>
        </div>
    </div>
    <div class="card p-3">
        <div class="row">
            @php
                $user = $purchase->client;
            @endphp
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>name:</strong>
                    {{ $user->name }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>phone_no:</strong>
                    {{ $user->phone_no }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>residential_address:</strong>
                    {{ $user->residential_address }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>office_address:</strong>
                    {{ $user->office_address }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>ohter_office_address:</strong>
                    {{ $user->ohter_office_address }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>email:</strong>
                    {{ $user->email }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>bill_no:</strong>
                    {{ $purchase->bill_no }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Machine:</strong>
                    <table class="table table-bordered m-0" id="">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Bill Number</th>
                                <th>Machine Name</th>
                                <th>Date Of Purchase</th>
                                <th>Delivery Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchase->multipleMachine as $key => $item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $item->bill_no}}</td>
                                    <td>{{ $item->machine->name}}</td>
                                    <td>{{ dateFormat($item->purchase_date) }}</td>
                                    <td>{{ $user->office_address }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
