@if(session('queryException'))
    <div class="alert alert-danger m-5">
        {{ session('queryException') }}
    </div>
@endif