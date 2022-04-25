@extends('layouts.app')

@section('content')

<div class="card-header mb-4 pb-0">
    <div class="d-flex justify-content-between">
        <h3>Единицы измерение</h3>
        <a href="{{ route('dashboard.metric.create') }}" class="btn btn-info btn-sm text-dark font-weight-bold"> Добавить </a>
    </div>
</div>
<div class="card-body  px-0 pt-0 pb-2">
    <table class="table text-center">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Edit</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach($metrics as $number => $metric)
                <tr>
                    <td>{{$number+1}}</td>
                    <td class="mb-0 text-sm">{{$metric->name}}</td>
                    <td class="mb-0 text-sm">
                        <a href="{{ route('dashboard.metric.edit', $metric->id) }}" class="bnt btn-warning btn-sm text-dark font-weight-bold text-xs btn-hover">Edit</a>
                    </td>
                    <td class="mb-0 text-sm">
                        <form action="{{ route('dashboard.metric.destroy', $metric->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm text-white font-weight-bold text-xs btn-hover">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $metrics->links() }}
</div>

@endsection
