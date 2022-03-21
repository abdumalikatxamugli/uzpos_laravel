@include('partials.validation_errors')

<form action="{{ route('dashboard.client.update', $client->id) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="text" name="name" value="{{ $client->name }}">
    <button>update</button>
</form>
