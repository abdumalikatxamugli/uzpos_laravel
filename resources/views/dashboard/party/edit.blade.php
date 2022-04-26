
@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body">
    <a href="{{ route('dashboard.party.index') }}" class="text-danger text-sm font-weight-light mb-3 d-block">Back</a>
    <form action="{{ route('dashboard.party.update', $party->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div>Дата приема</div>
                <h5>{{ date( 'd.m.Y' , strtotime( $party->check_in ) ) }}</h5>
            </div>
            <div class="col-md-6">
                <div>Пункт приема</div>
                <h5>
                    {{ $party->point->name }}
                </h5>
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
            @foreach($party->items as $number => $item)
            <tr>
                <td>{{ $number+1 }}</td>
                <td class="mb-0 text-sm">{{ $item->product->name }}</td>
                <td class="mb-0 text-sm">{{ $item->quantity }} </td>
                <td class="mb-0 text-sm">
                    <form action="{{ route('dashboard.item.destroy', $item->id) }}" method="POST">
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
@include('dashboard.item.create')
@endsection
