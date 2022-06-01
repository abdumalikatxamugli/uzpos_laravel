@extends('layouts.app')

@section('content')
    <div class="card-body">
        <h4 class="d-flex justify-content-between mb-5">
            <span>Счет фактуры по данному периоду</span>
        </h4>
        <form class="mb-5">
            <label>От</label>
            <input type="date" name="from" required>
            <label>До</label>
            <input type="date" name="to" required>
            <button class="btn btn-sm btn-info mb-0">Показать</button>
        </form>
        @include('partials.validation_errors')
        <table class="table text-center" style="font-size:12px">
            <thead>
                <tr>
                    <td>Филиал</td>
                    <td>Расход</td>
                </tr>
            </thead>
            <tbody>
                @foreach($expenses as $index=>$expense)
                <tr>
                    
                    <td>{{ $expense->pname }}</td>
                    <td>{{ $expense->all_amount }}</td>
                    
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
