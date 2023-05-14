
@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body px-5">
    <div class="row">
        <div class="col-md-5">
            <div>Дата приема</div>
            <h5 class="font-weight-bold">{{ date( 'd.m.Y' , strtotime( $party->check_in ) ) }}</h5>
        </div>
        <div class="col-md-5">
            <div>Пункт приема</div>
            <h5 class="font-weight-bold">
                {{ $party->point->name }}
            </h5>
        </div>
        @if($party->status == 1 && count( $party->items ) > 0 )
            <div class="col-md-2">
                <form action="{{ route('dashboard.party.finish', $party->id) }}">
                    @csrf
                    <button class="btn btn btn-success mb-0">Подтверждать</button>
                </form>
            </div>
        @endif
    </div>
</div>
<div class="card-body px-0 pt-0 pb-2">
    <table class="table table-hover table-stripped text-center">
        <thead>
            <tr>
                <th class="text-uppercase small-text">#</th>
                <th class="text-uppercase small-text">Название</th>
                <th class="text-uppercase small-text">Количество</th>
                <th class="text-uppercase small-text" width="5%"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($party->items as $number => $item)
            <tr>
                <td>{{ $number+1 }}</td>
                <td class="mb-0 text-sm">{{ $item->product->name }}</td>
                <td class="mb-0 text-sm">{{ $item->quantity }} </td>
                <td class="mb-0 text-sm">
                    @if($party->status==1)
                        <form action="{{ route('dashboard.item.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm text-white font-weight-bold text-xs btn-hover">
                                <i class="material-icons">remove</i>
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if($party->status==1 )
    <hr/>
    @include('dashboard.item.create')
@endif
@endsection
