@extends('layouts.app')

@section('content')
<div class="card-body">
<h4>Отчет товаров по магазинам</h4>
<form>
    <input type="hidden" name="run" value="1">
    <div class="row">
        <b>Фильтры</b>
        <div class="col-md-2">
            <span>Склад/магазин</span>
            <select name="point_id" class="form-control">
                @if($is_admin || $is_warehouse)
                    <option value="0">Все</option>
                @endif
                @foreach($points as $point)
                    <option value="{{ $point->id }}" {{$current_point_id == $point->id ? 'selected' : '' }}> {{ $point->name }} </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-success btn font-weight-bold mb-0">Посмотреть</button>
        </div>
    </div>
    
</form>

<table class="table table-success mt-3 text-center">
    <thead>
        <tr>
            <th>Филиал</th>
            <th>Название продукта</th>
            <!-- <th>Бренд</th>
            <th>Категория</th> -->
            <th>Количество</th>
        </tr>
    </thead>
    <tbody>
        @foreach($result as $pp)
        <tr>
            <td>{{ $pp->point_name }}</td>
            <td>{{ $pp->product_name }}</td>
            <!-- <td>{{ $pp->brand_name }}</td>
            <td>{{ $pp->category_name }}</td> -->
            <td>{{ $pp->quantity }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>

@endsection
