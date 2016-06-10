@if (Session::has('flash_message'))
    <div class="alert alert-{!! Session::get('flash_type', 'info') !!} top-buffer">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ Session::get('flash_message') }}
    </div>
@endif