@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body">

<form action="{{ route('dashboard.product.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <input type="text" name="name" class="form-control mb-3" placeholder="Название">
        </div>
        <div class="col-md-6">
            <input type="text" name="bar_code" class="form-control mb-3" placeholder="Штрих код">
        </div>
        <div class="col-md-2">
            <input type="text" name="bulk_price" class="form-control mb-3" placeholder="Оптовая цена">
        </div>
        <div class="col-md-2">
            <input type="text" name="one_price" class="form-control mb-3" placeholder="Розничная цена">
        </div>
        <div class="col-md-3">
            <input type="text" name="alert_limit" class="form-control mb-3" placeholder="Минимальная количество">
        </div>
    </div>
    <button class="btn btn-success btn-sm font-weight-bold">save</button>
</form>

</div>

@endsection
