@extends('layouts.app')

@section('content')
    <div class="card-header-primary">
        <h4>Заказ</h4>
        <small>ID: {{ $order->id }}</small>
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
    <div class="card-body">
        <h5 class="mb-5 d-flex justify-content-between">
            <b>Данные клиента</b>
            @if($order->status == 1 && $order->shop_id == auth()->user()->point_id)
                <button class="btn btn-info mb-0 d-flex align-items-center justify-content-center" onclick="addClient()">
                    <span>
                        <i class="material-icons">add</i>
                    </span>
                </button>
            @endif
        </h5>
        @if($order->client)
        <div class="row">
            <div class="col-md-4">
                <h6>Тип клиента</h6>
                <b>{{$order->client? $order->client->client_type_name : '' }}</b>
            </div>
            <div class="col-md-3">
                <h6>ФИО/Название</h6>
                <b>{{$order->getClientFullName()}}</b>
            </div>
            <div class="col-md-3">
                <h6>Реквизиты</h6>
                <b>{{$order->client ? $order->client->getClientCredentials() : ''}}</b>
            </div>
            <div class="col-md-2">
                <h6>Долги</h6>
                @if($order->client)
                    <a href="{{ route('debt.client.index', $order->client->id) }}" class="btn mb-0 btn-sm btn-danger" target="_blank">
                        Посмотреть историю долгов
                    </a>
                @endif
            </div>
        </div>
        @endif
    </div>
    <div class="card-body">
        <div>
            @include('dashboard.order.components.orderItems')            
        </div>        
    </div>
    <div class="card-body">
        @include('dashboard.order.components.payment')
        <div class="row my-5 text-center" x-data="{open:false}">
            <div class="col-md-4">
                <h5>
                    Место сбора
                </h5>  
            </div>
            <div class="col-md-4">
                <template x-if="!open">    
                    <h5>{{ $order->from_point->name }}</h5>
                </template>
                <template x-if="open">
                    <form action="{{route('order.changeFromPoint', $order)}}" method="POST">
                        @csrf  
                        <div class="row"> 
                            <div class="col-md-8"> 
                                <select name="point_id" class="form-control">
                                    @foreach($points as $point)
                                        <option value="{{$point->id}}">{{$point->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-success">Поменять</button>
                            </div>
                        </div>
                    </form>
                </template>                
            </div>
            <div class="col-md-4">
                @if($order->status==1  && $order->shop_id == auth()->user()->point_id)
                    <template x-if="!open">
                        <button type="button" class="btn btn-success" x-on:click="open=true">Поменять</button>
                    </template>
                @endif
            </div>
        </div>    
        @if($order->status == 1 && $order->shop_id == auth()->user()->point_id)
            <div class="my-3">
                @if($order->canBeConfirmed() && $order->client && $order->supplying_division_id == auth()->user()->division_id)
                    <form action="{{ route('order.confirm', $order->id) }}">
                        @csrf
                        <button class="btn btn-info w-100 p-3">Подтверждать</button>
                    </form>
                @else
                    @include('dashboard.order.components.confirmation_errors')
                @endif
            </div>
        @endif
    </div>
    <script>
        function addClient(){
            window.open(`{{ route('dashboard.client.index') }}?popup=true&order_id={{$order->id}}`, 'name' + Math.random(), 'width=1200,height=800');
        }
        function triggerRefresh() {
            window.location.assign(window.location.href);
        }        
    </script>
@endsection
