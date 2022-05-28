
@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body">

    <form action="{{ route('dashboard.expense.store') }}" method="POST">
        @csrf
        <label>Сумма</label>
        <input type="number" step=".01" name="amount" class="form-control mb-3">
        <button class="btn btn-success btn-sm font-weight-bold">Сохранить</button>
    </form>

</div>

@endsection
