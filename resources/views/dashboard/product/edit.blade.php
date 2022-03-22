@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body">

<form action="{{ route('dashboard.product.update', $product->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <input type="text" name="name" class="form-control mb-3" placeholder="Название" value="{{$product->name}}">
        </div>
        <div class="col-md-6">
            <input type="text" name="bar_code" class="form-control mb-3" placeholder="Штрих код" value="{{$product->bar_code}}">
        </div>
        <div class="col-md-2">
            <input type="text" name="bulk_price" class="form-control mb-3" placeholder="Оптовая цена" value="{{$product->bulk_price}}">
        </div>
        <div class="col-md-2">
            <input type="text" name="one_price" class="form-control mb-3" placeholder="Розничная цена" value="{{$product->one_price}}">
        </div>
        <div class="col-md-3">
            <input type="text" name="alert_limit" class="form-control mb-3" placeholder="Минимальная количество" value="{{$product->alert_limit}}">
        </div>
    </div>
    <button class="btn btn-success btn-sm font-weight-bold">save</button>
</form>

</div>

@endsection

