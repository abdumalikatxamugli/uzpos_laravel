@extends('layouts.app')

@section('content')
<div class="card-body">
<h4>

    {{ $is_warehouse ? 'Отчет по товарам (бренд/категория)' : ''}}
    {{ $is_seller ? 'Остаток товара в магазине' : '' }}
</h4>
<form>
    <input type="hidden" name="run" value="1">
    @if($run)
        <a href="{{ route('goodsExport', ['point_id'=>$current_point_id, 'category_id'=>$current_category_id, 'brand_id'=>$current_brand_id, 'exists'=>$exists]) }}" target="_blank" class="btn btn-danger mb-3 btn-sm">
            Экспортировать в excel
        </a>
    @endif
    <div class="row">
        <b>Фильтры</b>
        @if($is_admin)
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
        @endif
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
        @if($is_admin)
            <div class="col-md-3">
                <span>Имеющиеся/Заканчивающиеся</span>
                <select name="exists" class="form-control">
                    <option value="0" {{ $exists == 0 ? 'selected':'' }}>Заканчивающиеся</option>
                    <option value="1" {{ $exists == 1 ? 'selected':'' }}>Имеющиеся</option>                
                </select>
            </div>
        @endif

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
