@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body p-5">
    <form action="{{ route('dashboard.product.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="name" class="form-control mb-3" placeholder="Название">
            </div>
            <div class="col-md-3">
                <input type="text" name="bar_code" class="form-control mb-3" placeholder="Штрих код">
            </div>
            <div class="col-md-2">
                <input type="number" name="bulk_price" class="form-control mb-3" placeholder="Оптовая цена">
            </div>
            <div class="col-md-2">
                <input type="number" name="one_price" class="form-control mb-3" placeholder="Розничная цена">
            </div>
            <div class="col-md-2">
                <input type="number" name="alert_limit" class="form-control mb-3" placeholder="Минимальная количество">
            </div>            
        </div>
        <div class="row mt-5">
            <div class="col-md-4">
                <div>Категория</div>
                <select name="category_id" class="form-control mb-3">
                    <option value="" selected disabled></option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <div>Бренд</div>
                <select name="brand_id" class="form-control mb-3">
                    <option value="" selected disabled></option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <div>Единица измерения</div>
                <select name="metric_id" class="form-control mb-3">
                    <option value="" selected disabled></option>
                    @foreach($metrics as $metric)
                        <option value="{{ $metric->id }}">{{ $metric->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button class="btn btn-success btn-sm font-weight-bold mt-5 px-5 py-2">
            <i class="material-icons">check</i>
        </button>
    </form>
</div>

@endsection
