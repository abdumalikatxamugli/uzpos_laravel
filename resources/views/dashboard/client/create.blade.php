@extends('layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body">

<form action="{{ route('dashboard.client.store') }}" method="POST">
    @csrf
    <div class="row" x-data="{client_type:1}">
        <div class="col-md-6">
            <input type="radio" name="client_type" id="client_type_fiz" value="0" x-model="client_type">
            <label for="client_type_fiz">Физ. лицо</label>
        </div>
        <div class="col-md-6">
            <input type="radio" name="client_type" id="client_type_yur" value="1" x-model="client_type">
            <label for="client_type_yur">Юр. лицо</label>
        </div>

        <div class="col-md-12">
            <template x-if="client_type==0">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="pinfl" class="form-control mb-3" placeholder="ПИНФЛ">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="psery" class="form-control mb-3" placeholder="Серия паспорта">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="pnumber" class="form-control mb-3" placeholder="Номер паспорта">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="fname" class="form-control mb-3" placeholder="Фамилия">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="lname" class="form-control mb-3" placeholder="Имя">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="mname" class="form-control mb-3" placeholder="Отчество">
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="dbirth" class="form-control mb-3" placeholder="Дата рождения">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="occupation" class="form-control mb-3" placeholder="Профессия">
                    </div>
                </div>
            </template>
        </div>

        <div class="col-md-12">
            <template x-if="client_type==1">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="inn" class="form-control mb-3" placeholder="ИНН">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="company_name" class="form-control mb-3" placeholder="Название компании">
                    </div>
                </div>
            </template>
        </div>

        <div class="col-md-4">
            <input type="text" name="phone_number" class="form-control mb-3" placeholder="Номер телефона">
        </div>
        <div class="col-md-12 mb-5">
            <label>Область</label><br>
            <select name="region_id" class="form-control">
                @foreach($regions as $index=>$region)
                    <option value="{{$index}}">{{ $region }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <button class="btn btn-success btn-sm font-weight-bold">save</button>
</form>

</div>

@endsection
