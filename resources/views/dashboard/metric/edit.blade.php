
@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body">
    <a href="{{ route('dashboard.metric.index') }}" class="text-danger text-sm font-weight-light mb-3 d-block">
        Назад
    </a>
    <form action="{{ route('dashboard.metric.update', $metric->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="name" value="{{ $metric->name }}" class="form-control mb-4">
        <button class="btn btn-sm font-weight-bold btn-info">
            <i class="material-icons">check</i>
        </button>
    </form>
</div>

@endsection
