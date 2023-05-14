
@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body px-5 pt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="font-weight-bold">Дата перемешения</div>
            <h5>{{ date('d.m.Y', strtotime($transfer->transfer_date) ) }}</h5>
        </div>
        <div class="col-md-3">
            <div class="font-weight-bold">От Пункта</div>
            <h5>{{ $transfer->from_point->name }}</h5>
        </div>
        <div class="col-md-3">
            <div class="font-weight-bold">К Пункту</div>
            <h5>{{ $transfer->to_point->name }}</h5>
        </div>
        @if($transfer->status == 1 && $transfer->canBeConfirmed())
            <div class="col-md-2">
                <form action="{{ route('dashboard.transfer.finish', $transfer->id) }}">
                    @csrf
                    <button class="btn btn-success px-5">Завершить</button>
                </form>
            </div>
        @endif
    </div>
</div>
<hr/>
<div class="card-body px-0 p-3">
    <table class="table  text-center">
        <thead>
            <tr>
                <th class="small-text">#</th>
                <th class="small-text">Название</th>
                <th class="small-text">Количество</th>
                <th class="small-text" width="10%"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($transfer->items as $number => $item)
            <tr>
                <td>{{ $number+1 }}</td>
                <td class="mb-0 text-sm">{{ $item->product->name }}</td>
                <td class="mb-0 text-sm">{{ $item->quantity }} </td>
                <td class="mb-0 text-sm">
                    @if($transfer->status == 1 )
                        <form action="{{ route('dashboard.transferItem.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm text-white font-weight-bold text-xs btn-hover">
                                <i class="material-icons">delete</i>
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@if($transfer->status == 1  && $transfer->from_point_id == auth()->user()->point_id)
    @include('dashboard.transferItem.create')
@endif
@if($transfer->status == 2) 
    <div class="text-danger text-center p-3">
        Перемешения завершен
    </div>
@endif

@endsection
