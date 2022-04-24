
@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body">
    <a href="{{ route('dashboard.brand.index') }}" class="text-danger text-sm font-weight-light mb-3 d-block">Back</a>
    <form action="{{ route('dashboard.brand.update', $brand->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="name" value="{{ $brand->name }}" class="form-control mb-4">
        <button class="btn btn-sm font-weight-bold btn-info">update</button>
    </form>
</div>

@endsection
