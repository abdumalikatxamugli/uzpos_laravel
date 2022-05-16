@extends('layouts.app')

@section('content')
    <div class="card-body">
        <h4>Долги: {{$client->full_name}}</h4>
        @include('partials.validation_errors')
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>Дата задолженности</th>
                    <th>Сумма задолженности</th>
                    <th>Погашенная сумма</th>
                    <th>Баланс</th>
                    <th>История погашений</th>
                    <th>Перейти на заказ</th>
                    <th>Погасить</th>
                </tr>
            </thead>
            <tbody>
                @foreach($debts as $debt)
                    <tr>
                        <td>{{ date('d.m.Y', strtotime($debt->payment_date) ) }}</td>
                        <td>{{ $debt->amount }}</td>
                        <td>{{ $debt->total_repaid }}</td>
                        <td>{{$debt->total_repaid - $debt->amount }}</td>
                        <td>
                            <a href="{{ route('debt.repay_history', $debt->id) }}" class="btn btn-link mb-0 btn-sm text-danger">
                                Посмотреть историю погашений
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('dashboard.orders.edit', $debt->order_id) }}" class="btn btn-link mb-0 btn-sm text-danger">
                                Перейти на заказ
                            </a>
                        </td>
                        <td x-data="{open:false}">
                            <template x-if="!open">     
                                <button 
                                    href="route('dashboard.orders.edit', $debt->order_id)" 
                                    class="btn btn-link mb-0 btn-sm text-success"
                                    x-on:click="open=true"    
                                >
                                    Погасить
                                </button>
                            </template>
                            <template  x-if="open">
                                <form action="{{ route('debt.repay', $debt->id) }}" method="POST">
                                    @csrf
                                    <input type="date" value="{{ date('Y-m-d') }}" name="repayment_date" readonly> <br>
                                    <input type="number" name="amount" step=".01"><br>
                                    <button class="btn btn-sm mb-0 btn-success">Погасить</button><br>
                                    <button class="btn btn-sm mb-0 text-danger" type="button" x-on:click="open=false">x</button>
                                </form>
                            </template>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
