@include('partials.validation_errors')

<form action="{{ route('dashboard.metric.update', $metric->id) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="text" name="name" value="{{ $metric->name }}">
    <button>update</button>
</form>
