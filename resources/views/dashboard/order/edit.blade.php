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
    <hr>
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
        <div>
            
        </div>
        <div class="row">
            <div class="col-md-4">
                <h6>Тип клиента</h6>
                <hr/>
                <b>{{$order->client? $order->client->client_type_name : '' }}</b>
            </div>
            <div class="col-md-3">
                <h6>ФИО/Название</h6>
                <hr/>
                <b>{{$order->getClientFullName()}}</b>
            </div>
            <div class="col-md-3">
                <h6>Реквизиты</h6>
                <hr/>
                <b>{{$order->client ? $order->client->getClientCredentials() : ''}}</b>
            </div>
            <div class="col-md-2">
                <h6>Долги</h6>
                <hr/>
                @if($order->client)
                    <a href="{{ route('debt.client.index', $order->client->id) }}" class="btn btn-link mb-0 btn-sm text-danger" target="_blank">
                        Посмотреть историю долгов
                    </a>
                @endif
            </div>
        </div>
        
    </div>
    <hr>
    <div class="card-body">
        <h5 class="mb-5 d-flex justify-content-between">
            <b>Товары</b>
        </h5>
        <div>
            @include('dashboard.order.components.orderItems')            
        </div>        
    </div>
    <hr>
    <div class="card-body">
        <h5 class="mb-5 d-flex justify-content-between">
            <b>Оплата</b>
        </h5>
        <table class="table table-bordered text-center mb-5">
            <thead>
                <tr>
                    <td>Дата оплаты</td>
                    <td>Тип оплаты</td>
                    <td>Сумма</td>
                    <td>Убрать</td>
                </tr>
            </thead>
            <tbody>
                @foreach($order->payments as $payment)
                <tr>
                    <td>
                        {{ $payment->payment_date }}
                    </td>
                    <td>
                        {{ $payment->payment_type_name }}
                    </td>
                    
                    <td>
                        {{ $payment->amount }}
                    </td>
                    <td>
                        @if($order->status == 1 && $order->shop_id == auth()->user()->point_id)
                            <form action="{{route('order.payments.delete', $payment->id)}}">
                                @csrf
                                <button class="btn btn-danger btn-sm mb-0">
                                    <i class="material-icons">close</i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <hr/>
        @if($order->status == 1 && $order->division_id == auth()->user()->division_id)
            <form action="{{route('order.append.payments')}}" method="POST">
                @csrf
                <div>
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Сумма к оплате</label>
                            <input type="text" readonly name="amount" class="form-control px-2" value="{{round( $order->getTotalCost() - $order->getTotalPaid() )}}">
                        </div>
                        <div class="col-md-3">
                            <label>Дата оплаты</label>
                            <input type="date" class="form-control px-2" name="payment_date" value="{{ date('Y-m-d') }}" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label>Тип оплаты</label>
                            <select class="form-control px-2" name="payment_type" >
                                @foreach($payment_types as $ptype)
                                    <option value="{{ $ptype['code'] }}" {{ $ptype['code']==1?'selected':'' }} >{{ $ptype['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Оплачено</label>
                            <input type="text" class="form-control px-2" name="payed_amount">
                        </div>
                        <div class="col-md-3">
                            <label>На валюте</label>
                            <select class="form-control px-2" name="payed_currency_type">
                                @foreach($currencies as $ptype)
                                    <option value="{{ $ptype['code'] }}">{{ $ptype['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>По курсу</label>
                            <input type="text" class="form-control px-2" name="payed_currency_rate" >
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label>Возврщено</label>
                            <input type="text" class="form-control px-2" name="change_amount">
                        </div>
                        <div class="col-md-3">
                            <label>На валюте</label>
                            <select class="form-control px-2" name="change_currency_type">
                                @foreach($currencies as $ptype)
                                    <option value="{{ $ptype['code'] }}">{{ $ptype['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>По курсу</label>
                            <input type="text" class="form-control px-2" name="change_currency_rate" >
                        </div>
                        <div class="col-md-3 d-flex align-items-end justify-content-end">
                            <button class="btn btn-info">
                                <i class="material-icons">check</i>
                            </button>
                        </div>
                    </div>
                </div>           
            </form> 
        @endif
        <hr>
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
        <hr>
        @if($order->status == 1 && $order->shop_id == auth()->user()->point_id)
            <div class="my-3">
                @if($order->canBeConfirmed() && $order->client)
                    <form action="{{ route('order.confirm', $order->id) }}">
                        @csrf
                        <button class="btn btn-info w-100 p-3">ПОДВЕРЖДАТЬ</button>
                    </form>
                @else
                    @include('dashboard.order.components.confirmation_errors')
                @endif
            </div>
        @endif
        @if($order->status == 2 && $order->shop_id == auth()->user()->point_id)
            <form action="{{ route('order.break', $order->id) }}">
                @csrf
                <button class="btn btn-danger w-100 p-3">Отбраковать заказ</button>
            </form>
        @endif
    </div>
    <script>
        function addClient(){
            window.open(`{{ route('dashboard.client.index', $order->id) }}`, 'name' + Math.random(), 'width=1200,height=800');
        }
        function triggerRefresh() {
            window.location.assign(window.location.href);
        }        
    </script>
@endsection
