
@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body">

    <div>
        <div class="row">
            <div class="col-md-4">
                <div>Дата перемешения</div>
                <h5>{{ date('d.m.Y', strtotime($transfer->transfer_date) ) }}</h5>
            </div>
            <div class="col-md-3">
                <div>От Пункта</div>
                <h5>{{ $transfer->from_point->name }}</h5>
            </div>
            <div class="col-md-3">
                <div>К Пункту</div>
                <h5>{{ $transfer->to_point->name }}</h5>
            </div>
            @if($transfer->status == 1 && $transfer->from_point_id == auth()->user()->point_id)
                <div class="col-md-2">
                    <form action="{{ route('dashboard.transfer.finish', $transfer->id) }}">
                        @csrf
                        <button class="btn btn-lg btn-danger mb-0">Завершить</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
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
                    @if($transfer->status == 1  && $transfer->from_point_id == auth()->user()->point_id)
                        <form action="{{ route('dashboard.transferItem.destroy', $item->id) }}" method="POST">
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
</div>
@if($transfer->status == 1  && $transfer->from_point_id == auth()->user()->point_id)
    <hr/>
    @include('dashboard.transferItem.create')
@endif
@if($transfer->status == 2) 
    <div class="text-danger text-center p-3">
        Перемешения завершен
    </div>
@endif
@endsection
