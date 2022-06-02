@extends('layouts.app')

@section('content')
<div class="card-body">
<h4>Продажа магазина (Оптом / Розничный)</h4>
<div class="row">
    <div class="col-md-12">
        <form class="mb-5">
            <label>От</label>
            <input type="date" name="from" required  value="{{$from}}">
            <label>До</label>
            <input type="date" name="to" required value="{{$to}}">
            <span>Склад/магазин</span>
            <select name="point_id">
                @if($is_admin || $is_warehouse)
                    <option value="0">Все</option>
                @endif
                @foreach($points as $point)
                    <option value="{{ $point->id }}" {{$current_point_id == $point->id ? 'selected' : '' }}> {{ $point->name }} </option>
                @endforeach
            </select>
        <button class="btn btn-sm btn-info mb-0">Показать</button>
        </form>
    </div>
</div>

<table class="table table-success mt-3 text-center">
    <thead>
        <tr>
            <th>Филиад</th>
            <th>Статус</th>
            <th>Количество заказов</th>
            <th>Количество товаров</th>           
            <th>По типу</th>
        </tr>
    </thead>
    <tbody>
        @foreach($result as $pp)
        <tr>
            <td>{{ $pp->name }}</td>
            <td>
                {{ $pp->status == 1 ? 'ЧЕРНОВЕК':'' }}
                {{ $pp->status == 2 ? 'ПОДВЕРЖДЕН':'' }}
                {{ $pp->status == 3 ? 'БРАК':'' }}
            </td>
            <td>{{ $pp->quantity }}</td>
            <td>{{ $pp->oi_quantity }}</td>
            <td>{{ $pp->order_type == 1 ? 'Оптовый' : 'Розничный'}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>

@endsection
