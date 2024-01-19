@extends('layouts.app')
@section('page-title', 'Edit-'.ucfirst($title))
@section('content')
    <div class="row mb-2 align-items-center">
        <div class="col-md-6 d-flex justify-content-start">
            <h3>Edit {{ucfirst($title)}}</h3>
        </div>
        <div class="col-md-6 d-flex  justify-content-end">
            <div>
                <a class="btn btn-primary btn-sm" href="{{ route("$title.index") }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>
        </div>
    </div>
    <div class="card p-3">
        {!! Form::model($notification, ['method' => 'PATCH', 'route' => ["$title.update", $notification->id],'files'=> true]) !!}
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
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="group_id">Group:</label>
                    <select name="group[]" id="group_id" class="form-control Select2" multiple>
                        <option value="">Select</option>
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}" @if($notification && in_array($group->id,json_decode($notification->group))){{"selected"}}@endif>
                                {{ $group->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('group')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="">Date:</label>
                    {!! Form::date('date', null, ['placeholder' => 'Start Date', 'class' => 'form-control']) !!}
                </div>
                @error('date')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="">Time:</label>
                    {!! Form::time('time', null, ['placeholder' => 'End Date', 'class' => 'form-control']) !!}
                </div>
                @error('time')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="">Note:</label>
                    {!! Form::textarea('note', null, ['placeholder' => 'Note', 'class' => 'form-control']) !!}
                </div>
                @error('note')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
        </div>
            <button type="submit" class="btn btn-primary mt-5">Submit</button>
        {!! Form::close() !!}
    </div>

@endsection
