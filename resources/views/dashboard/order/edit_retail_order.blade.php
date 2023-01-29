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
                <div x-data="{currency_type:1, currency_kurs: 1, amount:{{ round( $order->getTotalCost() - $order->getTotalPaid() , 2) }} }">
                    <table class="table text-center">
                        <thead class="text-primary text-center">
                            <tr>
                                <th>Дата оплаты</th>
                                <th>Тип оплаты</th>
                                <th>Сумма</th>
                                <th>Валюта</th>
                                <th>Курс</th>
                                <th>Сумма в долларах</th>
                                <th></th>
                            </tr>
                        </thead>
                    
                    <tbody>
                        <tr>
                            <td>
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <input type="date" class="form-control px-2" name="payment_date" value="{{ date('Y-m-d') }}" readonly>
                            </td>
                            <td>
                                <select class="form-control px-2" name="payment_type" >
                                        @foreach($payment_types as $ptype)
                                            <option value="{{ $ptype['code'] }}" {{ $ptype['code']==1?'selected':'' }} >{{ $ptype['name'] }}</option>
                                        @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="amount" x-model = "amount">
                            </td>
                            <td>
                                <select class="form-control px-2" name="currency" x-model = "currency_type" x-on:change="if(currency_type==1){ currency_kurs=1 }">
                                    @foreach($currencies as $ptype)
                                        <option value="{{ $ptype['code'] }}">{{ $ptype['name'] }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <template x-if="currency_type==0">
                                    <input type="text" class="form-control px-2" name="currency_kurs" x-model = "currency_kurs">
                                </template>
                                <template x-if="currency_type==1">
                                    <input type="text" class="form-control px-2" name="currency_kurs" x-model = "currency_kurs" readonly>
                                </template>
                            </td>
                            <td>
                                <input type="text" class="form-control px-2" readonly name="amount_real" x-bind:value = "Math.round( amount/currency_kurs * 100 ) / 100">
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
