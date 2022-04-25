@extends('layouts.app')

@section('content')
<div class="card-body">
<h4>Отчет по товарам</h4>
<form>
    @csrf
    <div class="row">
        <div class="col-md-4">
            <span>Склад/магазин</span>
            <select name="pointId" class="form-control">
                @foreach($points as $point)
                    <option value="{{ $point->id }}" {{$current_point->id == $point->id ? 'selected' : '' }}> {{ $point->name }} </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button class="btn btn-success btn font-weight-bold mb-0">Generate report</button>
        </div>
    </div>
    
</form>

<table class="table table-success mt-3 text-center">
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
        @foreach($current_point->pointProducts as $pp)
        <tr>
            <td>{{ $pp->product->name }}</td>
            <td>{{ $pp->quantity }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>

@endsection
