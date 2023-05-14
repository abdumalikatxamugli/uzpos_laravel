@extends('layouts.app')

@section('content')

@include('partials.validation_errors')
<div class="card-header-primary mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="m-0">Перещении</h3>
        <a href="{{ route('dashboard.transfer.create') }}" class="btn btn-white btn-sm text-dark font-weight-bold"> Добавить </a>
    </div>
</div>
<div class="card-body  px-0 pt-0 pb-2">
    <table class="table text-center">
        <thead>
            <tr>
                <th class="small-text">#</th>
                <th class="small-text">Дата</th>
                <th class="small-text">Статус</th>
                <th class="small-text">От</th>
                <th class="small-text">К</th>
                <th class="small-text"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($transfers as $number => $transfer)
                <tr>
                    <td>{{$number+1}}</td>
                    <td class="mb-0 text-sm">{{ date( 'd.m.Y', strtotime( $transfer->transfer_date ) ) }}</td>
                    <td class="mb-0 text-sm">{{ $transfer->status_name}}</td>
                    <td class="mb-0 text-sm">{{ $transfer->from_point->name}}</td>
                    <td class="mb-0 text-sm">{{ $transfer->to_point->name}}</td>
                    <td class="mb-0 text-sm">{{ $transfer->reason}}</td>
                    <td class="mb-0 text-sm">
                        <a href="{{ route('dashboard.transfer.edit', $transfer->id) }}" class="btn btn-warning btn-sm text-dark font-weight-bold text-xs btn-hover">
                            <i class="material-icons">visibility</i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $transfers->links() }}
</div>

@endsection
