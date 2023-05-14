@if(session('errors') && is_object( session('errors') ) )
    <div class="alert alert-danger text-white text-sm">
        @foreach( session('errors')->getMessages() as $field => $errors)
            <span>{{ $field }}</span>
            <ul style="padding: 0;list-style:none">
                @foreach($errors as $error)
                    <li> {{$error}} </li>
                @endforeach
            </ul>
        @endforeach
    </div>
@endif


