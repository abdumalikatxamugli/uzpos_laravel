
@extends('layouts.app')

@section('content')

@include('partials.validation_errors')


<div class="card-body">

    <form action="{{ route('dashboard.party.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="mb-1 font-weight-bold">Дата приема</div>
                <input type="date" name="check_in" class="form-control">
            </div>
            <div class="col-md-6">
                <div class="font-weight-bold">Пункт приема</div>
                <select name="division_id" class="form-control">
                    @foreach($points as $point)
                        <option value="{{ $point->id }}">{{ $point->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button class="btn btn-success btn-sm font-weight-bold">
            <i class="material-icons">check</i>
        </button>
    </form>

</div>


@endsection
