
@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body">

    <form action="{{ route('dashboard.party.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div>Дата приема</div>
                <input type="date" name="check_in" class="form-control mb-3">
            </div>
            <div class="col-md-6">
                <div>Пункт приема</div>
                <select name="point_id" class="form-control mb-3">
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
