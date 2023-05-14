
@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body">
    <a href="{{ route('dashboard.point.index') }}" class="text-danger text-sm font-weight-light mb-3 d-block">Back</a>
    <form action="{{ route('dashboard.point.update', $point->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="name" value="{{ $point->name }}" class="form-control mb-4">
        <select name="point_type" class="form-control mb-3">
            <option value="1" {{$point->point_type == 1 ? "selected":""}}>Склад</option>
            <option value="2" {{$point->point_type == 2 ? "selected":""}}>Магазин</option>
        </select>
        <button class="btn btn-sm font-weight-bold btn-info">
            <i class="material-icons">check</i>
        </button>
    </form>
</div>

@endsection
