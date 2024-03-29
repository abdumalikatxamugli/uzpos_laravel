
@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body">

    <form action="{{ route('dashboard.transfer.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div class="mb-1 font-weight-bold">Дата перемешения</div>
                <input type="date" name="transfer_date" class="form-control mb-3" value="{{ date('Y-m-d') }}" readonly>
            </div>
            <div class="col-md-4">
                <div class="font-weight-bold">От Пункта</div>
                <select name="from_division_id" class="form-control mb-3">
                    @foreach($fromPoints as $point)
                        <option value="{{ $point->id }}">{{ $point->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <div class="font-weight-bold">К Пункту</div>
                <select name="to_division_id" class="form-control mb-3">
                    @foreach($toPoints as $point)
                        <option value="{{ $point->id }}">{{ $point->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button class="btn btn-success btn-sm font-weight-bold px-4">
            <i class="material-icons">check</i>
        </button>
    </form>

</div>

@endsection
