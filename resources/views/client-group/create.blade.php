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
                        <label for="">Name:</label>
                        {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                    </div>
                    @error('name')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="">Note:</label>
                        {!! Form::textarea('perpose', null, ['placeholder' => 'Note', 'class' => 'form-control']) !!}
                    </div>
                    @error('perpose')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="group_id">Client:</label>
                        <select name="client[]" id="group_id" class="form-control Select2" multiple>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" @if(old('client') && in_array($client->id,old('client'))){{"selected"}}@endif>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('client')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-5">Submit</button>
        {!! Form::close() !!}
    </div>
@endsection
