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
    <div class="row mt-3">
        <div class="col-md-4">
            <div class="mb-3">Категория</div>
            <select name="category_id" class="form-control mb-3">
                <option value="" selected disabled>--Выберите--</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <div class="mb-3">Бренд</div>
            <select name="brand_id" class="form-control mb-3">
                <option value="" selected disabled>--Выберите--</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}"  {{ $brand->id == $product->brand_id ? 'selected' : '' }}>{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <div class="mb-3">Единица измерения</div>
            <select name="metric_id" class="form-control mb-3">
                <option value="" selected disabled>--Выберите--</option>
                @foreach($metrics as $metric)
                    <option value="{{ $metric->id }}" {{ $metric->id == $product->metric_id ? 'selected' : '' }} >{{ $metric->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <button class="btn btn-success btn-sm font-weight-bold">save</button>
</form>

</div>

@endsection

