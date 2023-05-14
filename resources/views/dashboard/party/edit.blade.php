
@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body">
    {{-- <a href="{{ route('dashboard.party.index') }}" class="text-danger text-sm font-weight-light mb-3 d-block">Back</a> --}}
    <div>
        <div class="row">
            <div class="col-md-5">
                <div>Дата приема</div>
                <h5>{{ date( 'd.m.Y' , strtotime( $party->check_in ) ) }}</h5>
            </div>
            <div class="col-md-5">
                <div>Пункт приема</div>
                <h5>
                    {{ $party->point->name }}
                </h5>
            </div>
            @if($party->status == 1 && count( $party->items ) > 0 )
                <div class="col-md-2">
                    <form action="{{ route('dashboard.party.finish', $party->id) }}">
                        @csrf
                        <button class="btn btn-sm btn-danger mb-0">Завершить</button>
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
                <th class="text-uppercase small-text">#</th>
                <th class="text-uppercase small-text">Название</th>
                <th class="text-uppercase small-text">Количество</th>
                <th class="text-uppercase small-text"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($party->items as $number => $item)
            <tr>
                <td>{{ $number+1 }}</td>
                <td class="mb-0 text-sm">{{ $item->product->name }}</td>
                <td class="mb-0 text-sm">{{ $item->quantity }} </td>
                <td class="mb-0 text-sm">
                    @if($party->status==1 && $party->created_by_id == auth()->user()->id)
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

<hr/>
@if($party->status==1 && ( $party->point_id == auth()->user()->point_id || auth()->user()->username == 'owner' ) )
    @include('dashboard.item.create')
@endif
@endsection
