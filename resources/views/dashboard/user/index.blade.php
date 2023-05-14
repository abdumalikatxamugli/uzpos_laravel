@extends('layouts.app')

@section('content')
@include('partials.queryException')
<div class="card-header-primary mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="m-0">
            Пользователи
            
        </h3>
        <a href="{{ route('dashboard.user.create') }}" class="btn btn-white btn-sm text-dark font-weight-bold">
            Добавить
        </a>
    </div>
</div>
<div class="card-body  px-0 pt-0 pb-2">
    <table class="table text-center">
        <thead>
            <tr>
                <th class="small-text" width="10%">#</th>
                <th class="small-text"> Имя пользователя </th>
                <th class="small-text" width="8%"></th>
                <th class="small-text" width="8%"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $number => $user)
                <tr>
                    <td>{{$number+1}}</td>
                    <td class="mb-0 text-sm">{{$user->username}}</td>
                    <td class="mb-0 text-sm">
                        <a href="{{ route('dashboard.user.edit', $user->id) }}" class="btn btn-sm btn-warning">
                            <i class="material-icons">edit</i>
                        </a>
                    </td>
                    <td class="mb-0 text-sm">
                        <form action="{{ route('dashboard.user.destroy', $user->id) }}" method="POST">
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
    {{ $users->links() }}
</div>

@endsection
