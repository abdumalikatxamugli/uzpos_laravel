
@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body">

    <form action="{{ route('dashboard.transfer.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div>Дата перемешения</div>
                <h5>{{ date('d.m.Y', strtotime($transfer->transfer_date) ) }}</h5>
            </div>
            <div class="col-md-4">
                <div>От Пункта</div>
                <h5>{{ $transfer->from_point->name }}</h5>
            </div>
            <div class="col-md-4">
                <div>К Пункту</div>
                <h5>{{ $transfer->to_point->name }}</h5>
            </div>
        </div>
    </form>

</div>
<hr/>
<div class="card-body px-0 pt-0 pb-2">
    <table class="table  text-center">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantity</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transfer->items as $number => $item)
            <tr>
                <td>{{ $number+1 }}</td>
                <td class="mb-0 text-sm">{{ $item->product->name }}</td>
                <td class="mb-0 text-sm">{{ $item->quantity }} </td>
                <td class="mb-0 text-sm">
                    <form action="{{ route('dashboard.transferItem.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm text-white font-weight-bold text-xs btn-hover">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<hr/>
@include('dashboard.transferItem.create')
@endsection
