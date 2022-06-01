@extends('layouts.app')

@section('content')
<div class="card-body">
<h4>Расход продуктов(Оптом / Розничный)</h4>


<table class="table table-success mt-3 text-center">
    <thead>
        <tr>
            <th>Название продукта</th>
            <th>Количество продано</th>
            <th>По типу</th>
        </tr>
    </thead>
    <tbody>
        @foreach($result as $pp)
        <tr>
            <td>{{ $pp->product_name }}</td>
            <td>{{ $pp->quantity }}</td>
            <td>{{ $pp->order_type == 1 ? 'Оптовый' : 'Розничный'}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>

@endsection
