@extends('layouts.app')

@section('content')
<div class="card-body">
<h4>Отчет по продаже(по периоду/по магазину)</h4>


<table class="table table-success mt-3 text-center">
    <thead>
        <tr>
            <th>Статус</th>
            <th>Количество</th>
            <th>По типу</th>
        </tr>
    </thead>
    <tbody>
        @foreach($result as $pp)
        <tr>
            <td>
                {{ $pp->status == 1 ? 'ЧЕРНОВЕК':'' }}
                {{ $pp->status == 2 ? 'ПОДВЕРЖДЕН':'' }}
                {{ $pp->status == 3 ? 'ЧЕРНОВЕК':'' }}
            </td>
            <td>{{ $pp->quantity }}</td>
            <td>{{ $pp->order_type == 1 ? 'Оптовый' : 'Розничный'}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>

@endsection
