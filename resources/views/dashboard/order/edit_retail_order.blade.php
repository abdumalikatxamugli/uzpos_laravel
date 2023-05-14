@extends('layouts.appWithoutSidebar')

@section('content')
    <div class="card-header-primary">
        <h4>Заказ [Розничный] </h4>
        <small>ID: {{ $order->id }}</small> <br/>
    </div>
    <div class="card-body">
        <table class="table text-center mb-5">
            <thead class="text-primary" >
                <tr>
                    <th><strong>Общая сумма</strong></th>
                    <th><strong>Оплачено</strong></th>
                    <th><strong>Долг</strong></th>
                    <th><strong>Статус</strong></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ number_format($order->getTotalCost(), 2,'.', ' ')}}</td>
                    <td>{{number_format($order->getTotalPaid(),2, '.', ' ') }}</td>
                    <td>{{number_format( $order->getTotalCost() - $order->getTotalPaid(), 2, '.', ' ') }}</td>
                    <td><strong>{{$order->status_name}}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    <hr>
    <div class="card-body my-5">
        <h4 class="mb-5 text-primary d-flex justify-content-between">
            <b>Товары</b>
        </h4>
        <div>
            @include('dashboard.order.components.orderItems_retail')            
        </div>        
    </div>
    <div class="card-body">
        @include('dashboard.order.components.payment')
        @if($order->status == 1 && $order->supplying_division_id == auth()->user()->division_id)
            <div class="my-3">
                @if($order->canBeConfirmed())
                    <form action="{{ route('order.confirm', $order->id) }}">
                        @csrf
                        <button class="btn btn-info w-100 p-3">ПОДВЕРЖДАТЬ</button>
                    </form>
                @else
                    @include('dashboard.order.components.confirmation_errors')
                @endif
            </div>
        @endif
    </div>
    <script>
        
        function triggerRefresh() {
            window.location.assign(window.location.href);
        }        
    </script>
@endsection
