@extends('layouts.app')

@section('content')
    <div class="card-body">
        <h4>История погашений по долгу: {{$payment->id}}</h4>
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>Дата погашения</th>
                    <th>Погашенная сумма</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payment->repayments as $repayment)
                    <tr>
                        <td>{{ date('d.m.Y', strtotime($repayment->repayment_date) ) }}</td>
                        <td>{{ $repayment->amount }}</td>                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
