
@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body">

    <form action="{{ route('dashboard.expense.store') }}" method="POST">
        @csrf

        <label>Сумма</label>
        <input type="number" step=".01" name="amount" class="form-control mb-3">
        <label>Валюта</label>
        <select class="form-control mb-4" name="currency_type">
            @foreach($currencies as $ptype)
                <option value="{{ $ptype['code'] }}" {{ $ptype['code'] == 1 ? 'selected':'' }}>{{ $ptype['name'] }}</option>
            @endforeach
        </select>
        <label>Коммент</label>
        <input type="text" name="comment" class="form-control mb-3">
        <button class="btn btn-success btn-sm font-weight-bold">Сохранить</button>
    </form>

</div>

@endsection
