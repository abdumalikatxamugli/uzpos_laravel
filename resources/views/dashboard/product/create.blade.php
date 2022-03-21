@include('partials.validation_errors')
<form action="{{ route('dashboard.metric.store') }}" method="POST">
    @csrf
    <input type="text" name="name">
    <button>save</button>
</form>
