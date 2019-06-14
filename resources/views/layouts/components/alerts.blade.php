@if(session('alert_success'))
    <div class="alert alert-success fade show top-alert"  role="alert">
        {!!session('alert_success')!!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (session('resent'))
    <div class="alert alert-success fade show top-alert" role="alert">
        {{ __('A fresh verification link has been sent to your email address.') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if(session('alert_info'))
    <div class="alert alert-info fade show top-alert"  role="alert">
        {!!session('alert_info')!!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if(session('alert_warning'))
    <div class="alert alert-warning fade show top-alert"  role="alert">
        {!!session('alert_warning')!!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if(session('alert_danger'))
    <div class="alert alert-danger fade show top-alert"  role="alert">
        {!!session('alert_danger')!!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
