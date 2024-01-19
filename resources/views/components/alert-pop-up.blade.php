@if ($message = Session::get('success'))
    <div class="alert alert-dismissible fade show alert-success">
        <p class="m-0">{{ $message }}</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if ($message = Session::get('error'))
    <div class="alert alert-dismissible fade show alert-danger">
        <p class="m-0">{{ $message }}</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-dismissible fade show">
        <p class="m-0">{{ $message }}</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
