@if(session('errors'))
    <div class="alert alert-danger text-white text-sm">
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

