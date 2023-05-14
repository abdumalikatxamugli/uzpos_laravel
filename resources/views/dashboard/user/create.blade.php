@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body p-5">
    <form action="{{ route('dashboard.user.store') }}" method="POST" x-data="{}">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="first_name" class="form-control mb-3" placeholder="Фамилия">
            </div>
            <div class="col-md-4">
                <input type="text" name="last_name" class="form-control mb-3" placeholder="Имя">
            </div>
            <div class="col-md-4">
                <input type="text" name="phone" class="form-control mb-3" placeholder="Телефон" x-mask="(99)-999-99-99">
            </div>
            <div class="col-md-4">
                <input type="text" name="username" class="form-control mb-3" placeholder="Имя пользователя">
            </div>
            <div class="col-md-4">
                <input type="password" name="password" class="form-control mb-3" placeholder="Пароль">
            </div>
            <div class="col-md-4">
                <select name="division_id" class="form-control mb-3">
                    @foreach($points as $point)
                        <option value="{{$point->id}}">{{$point->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="user_role" class="form-control mb-3">
                    <option value="0">Админ</option>
                    <option value="1">Продовец</option>
                    <option value="3">Складчик</option>
                    <option value="4">Сборщик</option>
                    <option value="7">Доставщик</option>
                </select>
            </div>
            <div class="col-md-4">
                <select name="is_active" class="form-control mb-3">
                    <option value="1">Актив</option>
                    <option value="1">Неактив</option>
                </select>
            </div>
        </div>
        <button class="btn btn-success btn-sm font-weight-bold">
            <i class="material-icons">check</i>
        </button>
    </form>
</div>

@endsection
