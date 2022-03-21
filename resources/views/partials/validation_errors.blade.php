@if(session('errors'))
    <div>
        @foreach( session('errors')->getMessages() as $field => $errors)
            <span>{{ $field }}</span>
            <ul>
                @foreach($errors as $error)
                    <li> {{$error}} </li>
                @endforeach
            </ul>
        @endforeach
    </div>
@endif

