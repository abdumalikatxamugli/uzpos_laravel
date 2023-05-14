@extends('layouts.app')

@section('content')
@include('partials.queryException')
<div class="card-header-primary mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <h3  class="m-0">Магазины и склады</h3>
        <a href="{{ route('dashboard.point.create') }}" class="btn btn-white btn-sm text-dark font-weight-bold"> 
            Добавить
        </a>
    </div>
</div>
<div class="card-body  px-0 pt-0 pb-2">
<table class="table text-center">
    <thead>
        <tr>
            <th class="small-text" width="10%">#</th>
            <th class="small-text">Название</th>
            <th class="small-text">Тип</th>
            <th class="small-text" width="7%"></th>
            <th class="small-text" width="7%"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($points as $key=>$point)
            <tr>
                <td class="mb-0 text-sm">{{$key+1}}</td>
                <td class="mb-0 text-sm">{{$point->name}}</td>
                <td class="mb-0 text-sm">{{$point->division_type}}</td>
                <td>
                    <a class="btn btn-warning btn-sm text-dark " href="{{ route('dashboard.point.edit', $point->id) }}">
                        <i class="material-icons">edit</i>
                    </a>
                </td>
                <td>
                    <form action="{{ route('dashboard.point.destroy', $point->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm text-white font-weight-bold text-xs btn-hover">
                            <i class="material-icons">delete</i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $points->links() }}


@endsection
