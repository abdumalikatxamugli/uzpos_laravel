@extends('layouts.appWithoutSidebar')

@section('content')
    <div class="card-body">
        <h4>Результаты поиска у других</h4>
        @if(session('message'))
            <div class="p-3 alert alert-danger text-white">
                {{ session('message') }}
            </div>
        @endif
        <table class="table table-striped text-center mb-5">
            <thead>
                <tr>
                    <th>Продукт</th>
                    <th>Нужное количество</th>
                    <th>Количество у нас</th>
                    <th>Филиал</th>
                    <th>Количество в филиале</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($matches as $m)
                <tr>
                    <td>{{ $m->product_name }}</td>
                    <td>{{ $m->order_count }}</td>
                    <td>{{ $m->storehouse_count }}</td>
                    <td>{{ $m->match_division }}</td>
                    <td>{{ $m->match_count }}</td>
                    <td>
                        <form method="POST" action="{{route('transfer.request.create')}}">
                            @csrf
                            <input type="hidden" name="from_division_id" value="{{ $m->match_division_id }}">
                            <input type="hidden" name="to_division_id" value="{{  $order->supplying_division_id }}">
                            <input type="hidden" name="product_id" value="{{$m->product_id}}">
                            <input type="hidden" name="quantity" value="{{$m->request_quantity}}">
                            <button class="btn btn-warning btn-sm mb-0">Отправить запрос</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection