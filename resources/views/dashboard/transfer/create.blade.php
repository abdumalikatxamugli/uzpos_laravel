
@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body">

    <form action="{{ route('dashboard.transfer.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div>Дата перемешения</div>
                <input type="date" name="transfer_date" class="form-control mb-3">
            </div>
            <div class="col-md-4">
                <div>От Пункта</div>
                <select name="from_point_id" class="form-control mb-3">
                    @foreach($points as $point)
                        <option value="{{ $point->id }}">{{ $point->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <div>К Пункту</div>
                <select name="to_point_id" class="form-control mb-3">
                    @foreach($points as $point)
                        <option value="{{ $point->id }}">{{ $point->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button class="btn btn-success btn-sm font-weight-bold">save</button>
    </form>

</div>

@endsection
