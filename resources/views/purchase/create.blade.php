@extends('layouts.app')
@section('page-title', 'Add-'.ucfirst($title))
@section('content')
    <div class="row mb-2 align-items-center">
        <div class="col-md-6 d-flex justify-content-start">
            <h3>Add {{ucfirst($title)}}</h3>
        </div>
        <div class="col-md-6 d-flex  justify-content-end">
            <div>
                <a class="btn btn-primary btn-sm" href="{{ route("$title.index") }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>
        </div>
    </div>
    <div class="card p-3">
        {!! Form::open(['route' => "$title.store", 'method' => 'POST','files'=> true]) !!}
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="machine_id">Machine:</label>
                        <select name="machine_id" id="machine_id" class="form-control Select2">
                            <option value="">Select</option>
                            @foreach ($machine as $machi)
                                <option value="{{ $machi->id }}">
                                    {{ $machi->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('machine_id')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="client_id">Client:</label>
                        <select name="client_id" id="client_id" class="form-control Select2">
                            <option value="">Select</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('client_id')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="form-group">
                        <label for="">Date Of Purchase:</label>
                        {!! Form::date('purchase_date', null, ['placeholder' => 'Date Of Purchase', 'class' => 'form-control']) !!}
                    </div>
                    @error('purchase_date')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="form-group">
                        <label for="">Bill Number:</label>
                        {!! Form::text('bill_no', null, ['placeholder' => 'Bill Number', 'class' => 'form-control']) !!}
                    </div>
                    @error('bill_no')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <label for="">File:</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" name="file" accept="image/*" multiple>
                        <label class="custom-file-label" for="customFile">Choose File</label>
                    </div>
                    @error('file')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-5">Submit</button>
        {!! Form::close() !!}
    </div>
@endsection
