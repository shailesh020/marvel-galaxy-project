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
        {!! Form::model($machine, ['method' => 'PATCH', 'route' => ["$title.update", $machine->id],'files'=> true]) !!}
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
                <div class="col-xs-12 col-sm-12 col-md-12 mt-5">
                    @if ($machine->machineImages)
                        @foreach ($machine->machineImages as $image)
                            <button class="btn btn-outline-info btn-sm" id="machine_image_{{$image->id}}" type="button" onclick="removeImage({{$image->id}})">
                                <i class="fa fa-times" aria-hidden="true"></i>
                                    <img src='{{asset("file/machine/$image->photo")}}' alt="" width="100px" height="100px">
                                </a>
                            </button>
                        @endforeach
                    @endif
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-5">Submit</button>
        {!! Form::close() !!}
    </div>

@endsection
@section('script')
<script>
    function removeImage(id){
        let url = '/api/remove-machine-image/' + id;
        $.ajax({
            type:'GET',
            url:url,
            dataType:'json',
            success:function(data){
                console.log(data);
                console.log("data => ",data);
                if(data.status == 'success'){
                    $(`#machine_image_${id}`).remove();
                }
            }
        });
    }
</script>
@endsection
