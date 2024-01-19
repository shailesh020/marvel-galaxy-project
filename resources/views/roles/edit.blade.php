@extends('layouts.app')
@section('page-title', 'Add-Role')
@section('content')
    <div class="row mb-2">
        <div class="col-md-6 d-flex justify-content-start">
            <h2>Edit Role</h2>
        </div>
        <div class="col-md-6 d-flex  justify-content-end">
            <a class="btn btn-primary" href="{{ route('roles.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        </div>
    </div>
    <div class="card p-3">
        {!! Form::model($role, ['method' => 'PATCH', 'route' => ['roles.update', $role->id]]) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                </div>
                @error('name')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Permission:</strong>
                    <br />
                    @error('permission')
                        <p class="error">{{ $message }}</p>
                    @enderror
                    <table class="table">
                        <tr>
                            <th><input type="checkbox" name="" id="all"> <label for="all">All</label></th>
                            <th>Name</th>
                        </tr>
                        @foreach ($group as $value)
                            <tr>
                                <td>
                                    <input type="checkbox" onclick='permission("permission_{{ $value->group }}","{{ $value->group }}")' name="" id="permission_{{ $value->group }}" class="all permission_{{ $value->group }}">
                                    <label for="permission_{{ $value->group }}" class="ml-2">{{ $value->group }}</label>
                                </td>
                                <td>
                                    @foreach ($permission as $index => $perm)
                                        @if ($perm->group == $value->group)
                                            <input type="checkbox" name="permission[]" @if(in_array($perm->id, $rolePermissions)){{"checked"}}@endif onclick='permission("permission_{{ $perm->id }}","{{ $value->group }}")' id="permission_{{ $perm->id }}" class="all permission_{{ $value->group }} {{ $value->group }}" value="{{ $perm->id }}">
                                            <label for="permission_{{ $perm->id }}"
                                                class="mr-2">{{ $perm->name }}</label>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
@section('script')
    <script>
        $('#all').on('click', function() {
            if ($('#all').is(':checked')) {
                $('.all').attr('checked', true)
            } else {
                $('.all').attr('checked', false)
            }
        })

        function permission(id, group) {
            if ($(`#${id}`).is(':checked')) {
                $(`.${id}`).attr('checked', true)
            } else {
                $(`.${id}`).attr('checked', false)
            }
            var input_checked = 0;
            $('[name="permission[]"]').each((index, element) => {
                if ($(`#${element.id}`).is(':checked')) {
                    input_checked += 1;
                }
            });

            var class_checked = 0;
            $(`.${group}`).each((index, element) => {
                if ($(`#${element.id}`).is(':checked')) {
                    class_checked += 1;
                }
            });

            $('#all').attr('checked', false)
            if (input_checked == $('[name="permission[]"]').length) {
                $('#all').attr('checked', true)
            }

            $(`#permission_${group}`).attr('checked', false)
            if (class_checked == $(`.${group}`).length) {
                $(`#permission_${group}`).attr('checked', true)
            }

        }
    </script>
@endsection
