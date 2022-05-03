@extends('layouts.app')

@section('content')
    <div class="card-body">
        <h4 class="d-flex justify-content-between mb-5">
            <span>Заказы</span>
            <a class="btn btn-success btn-sm mb-0" href="{{route('dashboard.order.new')}}">Добавить</a>
        </h4>
        <table class="table text-center">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Уникальный ID заказа</td>
                    <td>Клиент</td>
                    <td>Количество товаров</td>
                    <td>Сумма</td>
                    <td>Всего оплачено</td>
                    <td>Посмотреть</td>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $index=>$order)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $order->id}}</td>
                    <td>{{ $order->getClientFullName() }}</td>
                    <td>{{ $order->getTotalItemCount() }}</td>
                    <td>{{ $order->getTotalCost() }}</td>
                    <td>{{ $order->getTotalPaid() }} </td>
                    <td> 
                        <a class="btn btn-warning btn-sm mb-0" href="{{route('dashboard.orders.edit', $order->id)}}">Посмотреть</a> 
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
