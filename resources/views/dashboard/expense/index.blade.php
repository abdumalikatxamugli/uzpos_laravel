@extends('layouts.app')

@section('content')

<div class="card-header-primary mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="m-0">Расходы</h3>
        <a href="{{ route('dashboard.expense.create') }}" class="btn btn-white btn-sm text-dark font-weight-bold"> Добавить </a>
    </div>
</div>
<div class="card-body  px-0 pt-0 pb-2">
    <table class="table text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>Дата</th>
                <th>Сотрудник</th>
                <th>Филиал</th>
                <th>Сумма</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $number => $expense)
                <tr>
                    <td>{{$number+1}}</td>
                    <td class="mb-0 text-sm">{{date('d.m.Y', strtotime($expense->created_at))}}</td>
                    <td class="mb-0 text-sm">{{$expense->staff->full_name}}</td>
                    <td class="mb-0 text-sm">{{$expense->division->name}}</td>
                    <td class="mb-0 text-sm">{{$expense->amount}}</td>
                    
                    <td class="mb-0 text-sm">
                        @if($expense->created_by_id == auth()->user()->id && date('d.m.Y', strtotime($expense->created_at) ) == date('d.m.Y'))
                            <form action="{{ route('dashboard.expense.destroy', $expense->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm text-white font-weight-bold text-xs btn-hover">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $expenses->links() }}
</div>

@endsection
