
@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body">

    <form action="{{ route('dashboard.metric.store') }}" method="POST">
        @csrf
        <input type="text" name="name" class="form-control mb-3">
        <button class="btn btn-success btn-sm font-weight-bold">save</button>
    </form>

</div>

@endsection
