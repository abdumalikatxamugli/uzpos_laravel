@include('partials.validation_errors')

<form action="{{ route('dashboard.point.update', $point->id) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="text" name="name" value="{{ $point->name }}">
    <button>update</button>
</form>
