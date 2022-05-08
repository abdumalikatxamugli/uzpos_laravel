@extends('layouts.app')

@section('content')
    <div class="card-body">
        <h4>Долги: {{$client->full_name}}</h4>
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>Дата задолженности</th>
                    <th>Сумма задолженности</th>
                    <th>Перейти на заказ</th>
                    <th>Погасить</th>
                </tr>
            </thead>
            <tbody>
                @foreach($debts as $debt)
                    <tr>
                        <td>{{ date('d.m.Y', strtotime($debt->payment_date) ) }}</td>
                        <td>{{ $debt->amount }}</td>
                        <td>
                            <a href="route('dashboard.orders.edit', $debt->order_id)" class="btn btn-link mb-0 btn-sm text-danger">
                                Перейти на заказ
                            </a>
                        </td>
                        <td>
                            <a href="route('dashboard.orders.edit', $debt->order_id)" class="btn btn-link mb-0 btn-sm text-success">
                                Погасить
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
