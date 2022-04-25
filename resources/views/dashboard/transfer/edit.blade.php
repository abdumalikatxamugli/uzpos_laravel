
@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body">

    <form action="{{ route('dashboard.transfer.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div>Дата перемешения</div>
                <input type="date" name="transfer_date" class="form-control mb-3" value="{{ date('Y-m-d', strtotime($transfer->transfer_date) ) }}">
            </div>
            <div class="col-md-4">
                <div>От Пункта</div>
                <select name="from_point_id" class="form-control mb-3">
                    @foreach($points as $point)
                        <option value="{{ $point->id }}" {{ $transfer->from_point_id == $point->id ? 'selected' : '' }}>{{ $point->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <div>К Пункту</div>
                <select name="to_point_id" class="form-control mb-3">
                    @foreach($points as $point)
                        <option value="{{ $point->id }}" {{ $transfer->to_point_id == $point->id ? 'selected' : '' }}>{{ $point->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button class="btn btn-success btn-sm font-weight-bold">save</button>
    </form>

</div>
<hr/>
<div class="card-body px-0 pt-0 pb-2">
    @include('partials.partial_validation_errors')
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
