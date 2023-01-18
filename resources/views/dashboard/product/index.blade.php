@extends('layouts.app')

@section('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="card-header card-header-primary">
    <div class="d-flex justify-content-between  align-items-center">
        <h3>Products</h3>
        <a href="{{ route('dashboard.product.create') }}" class="btn btn-white btn-sm text-dark font-weight-bold"> Create </a>
    </div>
</div>

<div class="card-body  px-0 pt-0 pb-2">
    <div class="p-3">
        <form class="px-5">
            <input type="hidden" name="run" value="1">
            <div class="row">
                <b>Фильтры</b>
                <div class="col-md-2">
                    <span>Название</span>
                    <select name="product_id" class="form-control" id="product_id">
                        <option value="0">Все</option>
                        @foreach($all_products as $product)
                            <option value="{{ $product->id }}" {{$current_product_id == $product->id ? 'selected' : '' }}> {{ $product->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <span>Бренд</span>
                    <select name="brand_id" class="form-control">
                        <option value="0">Все</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{$current_brand_id == $brand->id ? 'selected' : '' }}> {{ $brand->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <span>Категория</span>
                    <select name="category_id" class="form-control">
                        <option value="0">Все</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{$current_category_id == $category->id ? 'selected' : '' }}> {{ $category->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-success btn font-weight-bold mb-0">Посмотреть</button>
                </div>
            </div>
        </form>
    </div>

<table class="table text-center">
    <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Штрих код</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Edit</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $key=>$product)
            <tr>
                <td class="mb-0 text-sm">{{$key+1}}</td>
                <td class="mb-0 text-sm">{{$product->name}}</td>
                <td class="mb-0 text-sm">{{$product->bar_code}}</td>
                <td><a class="bnt btn-warning btn-sm text-dark font-weight-bold text-xs btn-hover" href="{{ route('dashboard.product.edit', $product->id) }}">Edit</a></td>
                <td>
                    <form action="{{ route('dashboard.product.destroy', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm text-white font-weight-bold text-xs btn-hover">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $products->withQueryString()->links() }}

<script>
    $(document).ready(function(){
        $("#product_id").select2();
    });
</script>
@endsection
