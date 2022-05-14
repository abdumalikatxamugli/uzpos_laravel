@extends('layouts.app')

@section('content')
    <div class="card-body">
        <h4 class="d-flex justify-content-between mb-5">
            <span>Заказы</span>
            <a class="btn btn-success btn-sm mb-0" href="{{route('dashboard.order.new', 1)}}">Добавить</a>
        </h4>
        @include('partials.validation_errors')
        <table class="table text-center">
            <thead>
                <tr>
                    <td>#</td>
                    <!-- <td>Уникальный ID заказа</td> -->
                    <td>Номер заказа</td>
                    <td>Статус заказа</td>
                    <td>Тип</td>
                    <td>Клиент</td>
                    <td>Количество товаров</td>
                    <td>Сумма</td>
                    <td>Всего оплачено</td>
                    <td>Посмотреть</td>
                    <td>Сборщик</td>
                    <td>Доставщик</td>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $index=>$order)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <!-- <td>{{ $order->id}}</td> -->
                    <td>{{ $order->order_no}}</td>
                    <td>{{ $order->status_name}}</td>
                    <td>{{ $order->order_type_name}}</td>
                    <td>{{ $order->getClientFullName() }}</td>
                    <td>{{ $order->getTotalItemCount() }}</td>
                    <td>{{ $order->getTotalCost() }}</td>
                    <td>{{ $order->getTotalPaid() }} </td>
                    <td> 
                        <a class="btn btn-danger btn-sm mb-0" href="{{route('dashboard.orders.edit', $order->id)}}">Посмотреть</a> 
                    </td>
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
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $orders->links() }}
    </div>
@endsection
