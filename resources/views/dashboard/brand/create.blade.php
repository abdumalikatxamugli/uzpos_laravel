
@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body">

    <form action="{{ route('dashboard.brand.store') }}" method="POST">
        @csrf
        <input type="text" name="name" class="form-control mb-3" placeholder="Название">
        <button class="btn btn-success btn-sm font-weight-bold">
            <i class="material-icons">check</i>
        </button>
    </form>

</div>

@endsection
