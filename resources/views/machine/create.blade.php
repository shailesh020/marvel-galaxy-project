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
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="">Name:</label>
                        {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                    </div>
                    @error('name')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="">Code:</label>
                        {!! Form::text('code', null, ['placeholder' => 'Code', 'class' => 'form-control']) !!}
                    </div>
                    @error('code')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="">Description:</label>
                        {!! Form::textarea('description', null, ['placeholder' => 'Description', 'class' => 'form-control','rows' => '2']) !!}
                    </div>
                    @error('description')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <label for="">Images:</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" name="photos[]" accept="image/*" multiple>
                        <label class="custom-file-label" for="customFile">Choose images</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-5">Submit</button>
        {!! Form::close() !!}
    </div>
@endsection
