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
        <h4 class="mb-5 text-primary d-flex justify-content-between">
            <b>Оплата</b>
        </h4>
        <table class="table text-center mb-5">
            <thead class="text-primary">
                <tr>
                    <th><strong>Дата оплаты</strong></th>
                    <th><strong>Тип оплаты</strong></th>
                    <th><strong>Валюта</strong></th>
                    <th><strong>Сумма</strong></th>
                    <th><strong>Курс</strong></th>
                    <th><strong>Сумма в долларах</strong></th>
                    <th></th>
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
        @if($order->status == 1 && $order->shop_id == auth()->user()->point_id)
            <form action="{{route('order.append.payments')}}" method="POST">
                @csrf
                <div x-data="paymentManager()">
                    <table class="table text-center">
                        <thead class="text-primary text-center">
                            <tr>
                                <th>Тип оплаты</th>
                                <th>Валюта</th>
                                <th>Курс</th>
                                <th>Оплчено</th>
                                <th>Сдачи</th>
                                <th></th>
                            </tr>
                        </thead>
                    
                    <tbody>
                        <tr>
                            <td>
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <input type="hidden" class="form-control px-2" name="payment_date" value="{{ date('Y-m-d') }}" readonly>
                            
                                <select class="form-control px-2" name="payment_type" x-model="payment_type">
                                        @foreach($payment_types as $ptype)
                                            <option value="{{ $ptype['code'] }}" {{ $ptype['code']==1?'selected':'' }} >{{ $ptype['name'] }}</option>
                                        @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control px-2" name="currency" x-model="currency">
                                    @foreach($currencies as $ptype)
                                        <option value="{{ $ptype['code'] }}">{{ $ptype['name'] }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" step="0.01" name="currency_kurs" class="form-control" x-model="currency_kurs">
                            </td>
                            <td>
                                <input type="number" step="0.01" name="payed_amount" class="form-control" x-model="payed_amount" x-on:change="setAmount()">
                            </td>
                            <td>
                                <input type="number" step="0.01" name="change_amount" class="form-control" x-model="change_amount" x-on:change="setAmount()">
                                <input type="hidden" name="amount" x-model="amount">
                                <input type="hidden" name="amount_real" x-model="amount_real">
                            </td>
                            <td>
                                <button class="btn btn-primary">
                                    <i class="material-icons">check</i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    </table>
                </div>           
            </form> 
            <script>
                function paymentManager()
                {
                    return {
                        payment_type: 1,
                        currency: 1,
                        currency_rate:1,
                        amount:0,
                        amount_real:0,
                        payed_amount: 0,
                        change_amount:0,
                        setAmount:function(){
                            this.amount = this.payed_amount - this.change_amount;
                            this.amount_real = this.amount / this.currency_rate;
                        }
                    }
                }
            </script>
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
