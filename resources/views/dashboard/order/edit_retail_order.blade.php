@extends('layouts.appWithoutSidebar')

@section('content')
    <div class="card-body">
        <h4>Заказ [Розничный] </h4>
        <small>ID: {{ $order->id }}</small> <br/>
        <small>Общая сумма: {{ number_format($order->getTotalCost(), 2,'.', ' ')}}</small><br/>
        <small>Оплачено: {{number_format($order->getTotalPaid(),2, '.', ' ') }}</small><br/>
        <small>Долг: {{number_format( $order->getTotalCost() - $order->getTotalPaid(), 2, '.', ' ') }}</small><br/>
        <div class="d-flex align-items-center" style="gap:10px">
            <small>Статус: </small><button class="btn btn-sm btn-primary mb-0">{{$order->status_name}}</button>
        </div>
    </div>
    <hr>
    <div class="card-body">
        <h5 class="mb-5 d-flex justify-content-between">
            <b>Данные клиента</b>
            @if($order->status == 1 && $order->shop_id == auth()->user()->point_id)
                <button class="btn btn-info mb-0 d-flex align-items-center justify-content-center" style="gap:10px;" onclick="addClient()">
                    <i class="ni ni-circle-08" style="font-size:14px;"></i>
                    <span >Добавить</span>
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
            @include('dashboard.order.components.orderItems_retail')            
        </div>        
    </div>
    <hr>
    <div class="card-body">
        <h5 class="mb-5 d-flex justify-content-between">
            <b>Оплата</b>
        </h5>
        <table class="table text-center mb-5">
            <thead>
                <tr>
                    <td>Дата оплаты</td>
                    <td>Тип оплаты</td>
                    <td>Валюта</td>
                    <td>Сумма</td>
                    <td>Курс</td>
                    <td>Сумма в сумах</td>
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
                        {{ $payment->currency_type_name }} 
                    </td>
                    <td>
                        {{ $payment->amount }}
                    </td>
                    <td>
                        {{ $payment->currency_kurs }}
                    </td>
                    <td>
                        {{ $payment->amount_real }}
                    </td>
                    <td>
                        @if($order->status == 1 && $order->shop_id == auth()->user()->point_id)
                            <form action="{{route('order.payments.delete', $payment->id)}}">
                                @csrf
                                <button class="btn btn-danger btn-sm mb-0">Убрать</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <hr/>
        @if($order->status == 1 && $order->shop_id == auth()->user()->point_id)
            <form action="{{route('order.append.payments')}}" method="POST">
                @csrf
                <div x-data="{currency_type:0, currency_kurs: 1, amount:0}">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <td>Дата оплаты</td>
                                <td>Тип оплаты</td>
                                <td>Валюта</td>
                                <td>Сумма</td>
                                <td>Курс</td>
                                <td>Сумма в сумах</td>
                                <td></td>
                            </tr>
                        </thead>
                    
                    <tbody>
                        <tr>
                            <td>
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <input type="date" class="form-control" name="payment_date">
                            </td>
                            <td>
                                <select id="" class="form-control" name="payment_type" >
                                        @foreach($payment_types as $ptype)
                                            <option value="{{ $ptype['code'] }}">{{ $ptype['name'] }}</option>
                                        @endforeach
                                </select>
                            </td>
                            <td>
                                <select id="" class="form-control" name="currency" x-model = "currency_type">
                                    @foreach($currencies as $ptype)
                                            <option value="{{ $ptype['code'] }}">{{ $ptype['name'] }}</option>
                                        @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="amount" x-model = "amount">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="currency_kurs" x-model = "currency_kurs">
                            </td>
                            <td>
                                <input type="text" class="form-control" readonly name="amount_real" x-bind:value = "currency_kurs * amount">
                            </td>
                            <td>
                                <button class="btn btn-info">Сохранить</button>
                            </td>
                        </tr>
                    </tbody>
                    </table>
                </div>           
            </form> 
        @endif
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
            window.open(`{{ route('dashboard.order.client.select', $order->id) }}`, 'name' + Math.random(), 'width=1200,height=800');
        }
        function triggerRefresh() {
            window.location.assign(window.location.href);
        }        
    </script>
@endsection
