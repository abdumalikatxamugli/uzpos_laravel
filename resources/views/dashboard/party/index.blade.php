@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-header-primary mb-4 ">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="m-0">Приход товаров</h3>
        <a href="{{ route('dashboard.party.create') }}" class="btn btn-white btn-sm text-primary font-weight-bold"> Create </a>
    </div>
</div>
<div class="card-body  px-0 pt-0 pb-2">
    <table class="table text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>Дата</th>
                <th>Филиал</th>
                <th>Статус</th>
                <th>Посмотреть</th>
                <th>Удалить</th>
            </tr>
        </thead>
        <tbody>
            @foreach($parties as $number => $party)
                <tr>
                    <td>{{$number+1}}</td>
                    <td class="mb-0 text-sm">{{ date( 'd.m.Y', strtotime( $party->check_in ) ) }}</td>
                    <td class="mb-0 text-sm">{{ $party->status_name }}</td>
                    <td class="mb-0 text-sm">{{ $party->point->name }}</td>
                    <td class="mb-0 text-sm">
                        <a href="{{ route('dashboard.party.edit', $party->id) }}" class="bnt btn-warning btn-sm text-dark font-weight-bold text-xs btn-hover">Посмотреть</a>
                    </td>
                    <td class="mb-0 text-sm">
                        @if($party->status != 2 && $party->point_id == auth()->user()->point_id)
                            <form action="{{ route('dashboard.party.destroy', $party->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm text-white font-weight-bold text-xs btn-hover">Удалить</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $parties->links() }}
</div>

@endsection
