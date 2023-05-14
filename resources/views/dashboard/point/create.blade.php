

@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body">

<form action="{{ route('dashboard.point.store') }}" method="POST">
    @csrf
    <input type="text" name="name" class="form-control mb-3" placeholder="Название">
    <select name="point_type" class="form-control mb-3">
        <option value="1">Склад</option>
        <option value="2">Магазин</option>
    </select>
    <button class="btn btn-success btn-sm font-weight-bold">
        <i class="material-icons">check</i>
    </button>
</form>

</div>

@endsection
