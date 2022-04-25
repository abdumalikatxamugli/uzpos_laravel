@extends('layouts.app')

@section('content')

<div class="card-header mb-4 pb-0">
    <div class="d-flex justify-content-between">
        <h3>Перещении</h3>
        <a href="{{ route('dashboard.transfer.create') }}" class="btn btn-info btn-sm text-dark font-weight-bold"> Добавить </a>
    </div>
</div>
<div class="card-body  px-0 pt-0 pb-2">
    <table class="table text-center">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Дата</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Edit</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Отменить</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transfers as $number => $transfer)
                <tr>
                    <td>{{$number+1}}</td>
                    <td class="mb-0 text-sm">{{ date( 'd.m.Y', strtotime( $transfer->transfer_date ) ) }}</td>
                    <td class="mb-0 text-sm">
                        <a href="{{ route('dashboard.transfer.edit', $transfer->id) }}" class="bnt btn-warning btn-sm text-dark font-weight-bold text-xs btn-hover">Edit</a>
                    </td>
                    <td class="mb-0 text-sm">
                        <form action="{{ route('dashboard.transfer.destroy', $transfer->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm text-white font-weight-bold text-xs btn-hover">Отменить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $transfers->links() }}
</div>

@endsection
