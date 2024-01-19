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
        {!! Form::model($user, ['method' => 'PATCH', 'route' => ["$title.update", $user->id],'files'=> true]) !!}
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
                        <label for="">Date Of Birth:</label>
                        {!! Form::date('dob', null, ['placeholder' => 'Date Of Birth', 'class' => 'form-control']) !!}
                    </div>
                    @error('dob')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="">Residential Address:</label>
                        {!! Form::textarea('residential_address', null, ['placeholder' => 'Residential Address', 'class' => 'form-control','rows' => '2']) !!}
                    </div>
                    @error('residential_address')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                @if ($title == 'clients')
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="">Office Address:</label>
                            {!! Form::textarea('office_address', null, ['placeholder' => 'Office Address', 'class' => 'form-control','rows' => '2']) !!}
                        </div>
                        @error('office_address')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="">Another Office Address:</label>
                            {!! Form::textarea('ohter_office_address', null, ['placeholder' => 'Another Office Address', 'class' => 'form-control','rows' => '2']) !!}
                        </div>
                        @error('ohter_office_address')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6"></div>
                @else
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="">Native Address:</label>
                            {!! Form::textarea('native_address', null, ['placeholder' => 'Native Address', 'class' => 'form-control','rows' => '2']) !!}
                        </div>
                        @error('native_address')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                @endif
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="">Email:</label>
                        {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                    </div>
                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="">Mobile Number:</label>
                        {!! Form::number('phone_no', null, ['placeholder' => 'Mobile Number', 'class' => 'form-control']) !!}
                    </div>
                    @error('phone_no')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                @if ($title != 'clients')
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="">Alternet Mobile Number:</label>
                            {!! Form::number('alternet_phone_no', null, ['placeholder' => 'Alternet Mobile Number', 'class' => 'form-control']) !!}
                        </div>
                        @error('phone_no')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlFile1">File:</label>
                            <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1">
                        </div>
                        @error('file')
                            <p class="error">{{ $message }}</p>
                        @enderror
                        @if ($user->file)
                            <a target="_blank" class="btn btn-warning btn-sm" href='{{asset("file/engineers/$user->file")}}'>View File</a>
                        @endif
                    </div>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        {!! Form::close() !!}
    </div>

@endsection
