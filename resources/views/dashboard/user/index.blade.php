@extends('layouts.app')

@section('content')

<div class="card-header-primary mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Users</h3>
        <a href="{{ route('dashboard.user.create') }}" class="btn btn-white btn-sm text-dark font-weight-bold"> Create </a>
    </div>
</div>
<div class="card-body  px-0 pt-0 pb-2">
    <table class="table text-center">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">username</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Edit</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $number => $user)
                <tr>
                    <td>{{$number+1}}</td>
                    <td class="mb-0 text-sm">{{$user->username}}</td>
                    <td class="mb-0 text-sm">
                        <a href="{{ route('dashboard.user.edit', $user->id) }}" class="bnt btn-warning btn-sm text-dark font-weight-bold text-xs btn-hover">Edit</a>
                    </td>
                    <td class="mb-0 text-sm">
                        <form action="{{ route('dashboard.user.destroy', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm text-white font-weight-bold text-xs btn-hover">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>

@endsection
