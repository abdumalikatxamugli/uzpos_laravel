@extends('layouts.app')

@section('content')
    @include('partials.queryException')
    <div class="card-header-primary">
        <h4 class="d-flex justify-content-between">
            <span>Заказы {{ $other_shop == 1 ? 'от других':'' }} [ {{$status_text}} ]</span>
            <a class="btn btn-white btn-sm mb-0 text-primary" href="{{route('dashboard.order.new', 1)}}">Добавить</a>
        </h4>
    </div>
    <div class="card-body">
         @include('partials.validation_errors')
        <table class="table table-bordered text-center" style="font-size:12px">
            <thead>
                <tr>
                    <td>#</td>
                    <!-- <td>Уникальный ID заказа</td> -->
                    <td>Номер заказа</td>
                    <td>Номер счет фактуры</td>
                    <td>Статус заказа</td>
                    <td>Тип</td>
                    <!-- <td>Клиент</td> -->
                    <td>Количество товаров</td>
                    <td>Сумма</td>
                    <td>Всего оплачено</td>
                    <td>Место заказа</td>
                    <td>Место сбора</td>
                    <td>ЭСФ</td>
                    <td>Просмотр</td>
                    <td>Сборщик</td>
                    <td>Доставщик</td>
                    <td>Оповещать клиента</td>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $index=>$order)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <!-- <td>{{ $order->id}}</td> -->
                    <td>{{ str_pad($order->order_no, 4, '0', STR_PAD_LEFT ) }}</td>
                    <td>{{ str_pad($order->esf_no, 4, '0', STR_PAD_LEFT )}}</td>
                    <td>{{ $order->status_name}}</td>
                    <td>{{ $order->order_type_name}}</td>
                    <td>{{ $order->getTotalItemCount() }}</td>
                    <td>{{ $order->getTotalCost() }}</td>
                    <td>{{ $order->getTotalPaid() }} </td>
                    <td>{{ $order->division->name }} </td>
                    <td>{{ $order->from_point->name }} </td>
                    <td> 
                        <a class="btn btn-primary btn-sm mb-0" href="{{route('order.genEsf', $order->id)}}" target="_blank">
                            <i class="material-icons">download</i>
                        </a> 
                    </td>  
                    <td> 
                        <a class="btn btn-primary btn-sm mb-0" data-shref="{{route('dashboard.orders.edit', $order->id)}}" href="#" onclick="openOrder(this, {{$order->order_type}})">
                            <i class="material-icons">visibility</i>
                        </a> 
                    </td>
                    @if($status==2)
                        <td>
                            @if(!$order->collectionRequest)
                                <div x-data="{open:false}">
                                    <template x-if="!open">
                                        <button class="btn btn-warning btn-sm mb-0" x-on:click="open=true">Сборщик</button>
                                    </template>
                                    <template x-if="open">
                                        <form action="{{ route('assignCollector') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <input type="hidden" name="status" value="1">
                                            <select name="assigned_id" class="form-control mb-2">
                                                @foreach($collectors as $collector)
                                                    <option value="{{ $collector->id }}">{{ $collector->full_name}}</option>
                                                @endforeach
                                            </select>
                                            <button class="btn btn-warning btn-sm mb-1">Назначить</button> <br>
                                            <button class="btn btn-danger btn-sm mb-0" type="button" x-on:click="open=false">Закрыть</button>
                                        </form>
                                    </template>
                                </div>
                            @else
                                {{$order->collectionRequest->status_text}}
                            @endif
                        </td>
                        <td>
                            @if(!$order->deliveryRequest)
                                <div x-data="{open:false}">
                                    <template x-if="!open">
                                        <button class="btn btn-success btn-sm mb-0" x-on:click="open=true">Доставщик</button>
                                    </template>
                                    <template x-if="open">
                                        <form action="{{ route('assignDeliver') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <input type="hidden" name="status" value="1">
                                            <input type="text" name="to_address" placeholder="Адрес" class="form-control mb-1">
                                            <input type="hidden" name="status" value="1">
                                            <select name="assigned_id" class="form-control mb-2">
                                                @foreach($delivers as $deliver)
                                                    <option value="{{ $deliver->id }}">{{ $deliver->full_name}}</option>
                                                @endforeach
                                            </select>
                                            <button class="btn btn-warning btn-sm mb-1">Назначить</button> <br>
                                            <button class="btn btn-danger btn-sm mb-0" type="button" x-on:click="open=false">Закрыть</button>
                                        </form>
                                    </template>
                                </div>
                            @else
                                {{$order->deliveryRequest->status_text}}
                            @endif
                        </td>
                        <td>
                            <a href="{{route('dashboard.order.notifyClient', $order->id)}}" class="btn btn-success btn-sm">
                                Оповещать клиента
                            </a>
                        </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $orders->links() }}
    </div>
    <script>
        function openOrder(el, type)
        {
            if(type == 1)
            {
                window.location.assign(el.dataset.shref);
            }
            else{
                window.open(`${el.dataset.shref}`, 'name' + Math.random(), 'width=1200,height=800');
            }
        }
    </script>
@endsection
