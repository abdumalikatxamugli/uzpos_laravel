@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body">

<form action="{{ route('dashboard.user.update', $user->id) }}" method="POST">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="col-md-4">
            <input type="text" name="first_name" class="form-control mb-3" placeholder="Фамилия" value="{{$user->first_name}}">
        </div>
        <div class="col-md-4">
            <input type="text" name="last_name" class="form-control mb-3" placeholder="Имя" value="{{$user->last_name}}">
        </div>
        <div class="col-md-4">
            <input type="text" name="phone" class="form-control mb-3" placeholder="Телефон" value="{{$user->phone}}">
        </div>
        <div class="col-md-4">
            <input type="text" name="username" class="form-control mb-3" placeholder="Username" value="{{$user->username}}">
        </div>
        <div class="col-md-4">
            <input type="password" name="password" class="form-control mb-3" placeholder="Password">
        </div>
        <div class="col-md-4">
            <select name="point_id" class="form-control mb-3" >
                @foreach($points as $point)
                    <option value="{{$point->id}}" {{ $point->id == $user->point_id ? 'selected' : '' }}>{{$point->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select name="user_role" class="form-control mb-3">
                <option value="0" {{$user->user_role == 0 ? 'selected' : '' }}>Админ</option>
                <option value="2" {{$user->user_role == 2 ? 'selected' : '' }}>Продовец</option>
                <option value="3" {{$user->user_role == 3 ? 'selected' : '' }}>Складчик</option>
                <option value="4" {{$user->user_role == 4 ? 'selected' : '' }}>Сборщик</option>
                <option value="7" {{$user->user_role == 7 ? 'selected' : '' }}>Доставшик</option>
            </select>
        </div>
        <div class="col-md-4">
            <select name="is_active" class="form-control mb-3">
                <option value="1" {{$user->is_active == 1 ? 'selected' : '' }}>Актив</option>
                <option value="0" {{$user->is_active == 0 ? 'selected' : '' }}>Неактив</option>
            </select>
        </div>
    </div>
    <button class="btn btn-success btn-sm font-weight-bold">save</button>
</form>

</div>

@endsection
