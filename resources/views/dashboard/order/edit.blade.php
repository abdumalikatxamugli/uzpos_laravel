@extends('layouts.app')

@section('content')
    <div class="card-body">
        <h4>Заказ</h4>
        <small>ID: {{ $order->id }}</small> <br/>
        <small>Общая сумма: $ {{ number_format($order->getTotalCost(), 2,'.', ' ')}}</small><br/>
        Оплачено: <br>
                         $ {{number_format($order->getTotalPaidByCurrencyType(1),2, '.', ' ') }} в долларах
                         <br/>
                         $ {{number_format($order->getTotalPaidByCurrencyType(0),2, '.', ' ') }} в сумах в эквиваленте 
                         {{number_format($order->getTotalPaidBySoums(0),2, '.', ' ') }} UZS    

                        </br>    

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
            @include('dashboard.order.components.orderItems')            
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
                    <td>Сумма в долларах</td>
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
                <div x-data="{currency_type:1, currency_kurs: 1, amount:{{ round( $order->getTotalCost() - $order->getTotalPaid() , 2) }} }">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <td>Дата оплаты</td>
                                <td>Тип оплаты</td>
                                <td>Сумма</td>
                                <td>Валюта</td>
                                <td>Курс</td>
                                <td>Сумма в долларах</td>
                                <td></td>
                            </tr>
                        </thead>
                    
                    <tbody>
                        <tr>
                            <td>
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <input type="date" class="form-control" name="payment_date" value="{{ date('Y-m-d') }}" readonly>
                            </td>
                            <td>
                                <select id="" class="form-control" name="payment_type" >
                                        @foreach($payment_types as $ptype)
                                            <option value="{{ $ptype['code'] }}" {{ $ptype['code']==1?'selected':'' }} >{{ $ptype['name'] }}</option>
                                        @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="amount" x-model = "amount">
                            </td>
                            <td>
                                <select class="form-control" name="currency" x-model = "currency_type" x-on:change="if(currency_type==1){ currency_kurs=1 }">
                                    @foreach($currencies as $ptype)
                                        <option value="{{ $ptype['code'] }}">{{ $ptype['name'] }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <template x-if="currency_type==0">
                                    <input type="text" class="form-control" name="currency_kurs" x-model = "currency_kurs">
                                </template>
                                <template x-if="currency_type==1">
                                    <input type="text" class="form-control" name="currency_kurs" x-model = "currency_kurs" readonly>
                                </template>
                            </td>
                            <td>
                                <input type="text" class="form-control" readonly name="amount_real" x-bind:value = "Math.round( amount/currency_kurs * 100 ) / 100">
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
        <div class="row my-5 text-center" x-data="{open:false}">
            <div class="col-md-4">
                <h5>Место сбора</h5>  
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
            window.open(`{{ route('dashboard.order.client.select', $order->id) }}`, 'name' + Math.random(), 'width=1200,height=800');
        }
        function triggerRefresh() {
            window.location.assign(window.location.href);
        }        
    </script>
@endsection
