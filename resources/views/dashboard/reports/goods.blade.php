@extends('layouts.app')

@section('content')
<div class="card-body">
<h4>Отчет по товарам</h4>
<form>
    <input type="hidden" name="run" value="1">
    <div class="row">
        <b>Фильтры</b>
        <div class="col-md-2">
            <span>Склад/магазин</span>
            <select name="point_id" class="form-control">
                @if($is_admin)
                    <option value="0">Все</option>
                @endif
                @foreach($points as $point)
                    <option value="{{ $point->id }}" {{$current_point_id == $point->id ? 'selected' : '' }}> {{ $point->name }} </option>
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
        
        <div class="col-md-2">
            <span>Доп. фильтр</span>
            <select name="exists" class="form-control">
                <option value="1" {{$exists === "1" ? 'selected' : '' }}>Есть</option>
                <option value="0" {{$exists === "0" ? 'selected' : '' }}>Нет</option>
            </select>
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-success btn font-weight-bold mb-0">Найти</button>
        </div>
    </div>
    
</form>

<table class="table table-success mt-3 text-center">
    <thead>
        <tr>
            <th>Филиал</th>
            <th>Название продукта</th>
            <th>Бренд</th>
            <th>Категория</th>
            <th>Количество</th>
        </tr>
    </thead>
    <tbody>
        @foreach($result as $pp)
        <tr>
            <td>{{ $pp->point_name }}</td>
            <td>{{ $pp->product_name }}</td>
            <td>{{ $pp->brand_name }}</td>
            <td>{{ $pp->category_name }}</td>
            <td>{{ $pp->quantity }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>

@endsection
