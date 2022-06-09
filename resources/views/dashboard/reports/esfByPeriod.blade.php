@extends('layouts.app')

@section('content')
    <div class="card-body">
        <h4 class="d-flex justify-content-between mb-5">
            <span>Счет фактуры по данному периоду (
                {{ $is_warehouse ? 'По всем' : '' }} 
                {{ $is_seller ? 'Магазин' : '' }}
                {{ $is_admin ? 'По всем' : '' }}
            ) </span>
        </h4>
        <form class="mb-5">
            <label>От</label>
            <input type="date" name="from" required  value="{{$from}}">
            <label>До</label>
            <input type="date" name="to" required value="{{$to}}">
            @if($is_admin)
                <label>Номер счет фактуры</label>
                <input type="text" name="esf_no" value="{{ $esf_no }}">
                <label>Клиент</label>
                <select name="current_client_id">
                    @if($is_admin || $is_warehouse)
                        <option value="0">Все</option>
                    @endif
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{$current_client_id == $client->id ? 'selected' : '' }}> {{ $client->full_name }} </option>
                    @endforeach
                </select>
            @endif
            <button class="btn btn-sm btn-info mb-0">Показать</button>
        </form>
        @include('partials.validation_errors')
        <table class="table text-center" style="font-size:12px">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Номер заказа</td>
                    <td>Номер счет фактуры</td>
                    <td>Продал</td>
                    <td>Статус заказа</td>
                    <td>Тип</td>
                    <td>Клиент</td>
                    <td>Количество товаров</td>
                    <td>Сумма</td>
                    <td>Всего оплачено</td>
                    <td>Скачать</td>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $index=>$order)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ str_pad($order->order_no, 4, '0', STR_PAD_LEFT ) }}</td>
                    <td>{{ str_pad($order->esf_no, 4, '0', STR_PAD_LEFT )}}</td>
                    <td>{{ $order->division->name }}</td>
                    <td>{{ $order->status_name}}</td>
                    <td>{{ $order->order_type_name}}</td>
                    <td>{{ $order->getClientFullName() }}</td>
                    <td>{{ $order->getTotalItemCount() }}</td>
                    <td>{{ $order->getTotalCost() }}</td>
                    <td>{{ $order->getTotalPaid() }} </td>
                    <td> 
                        <a class="btn btn-danger btn-sm mb-0" href="{{route('order.genEsf', $order->id)}}" target="_blank">Скачать</a> 
                    </td>                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
