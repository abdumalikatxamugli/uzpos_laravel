@extends($popup?'layouts.appWithoutSidebar':'layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body">

<form action="{{ route_with_query_params('dashboard.client.update', $client->id) }}" method="POST">
    @method('PUT')
    @csrf
    <input type="hidden" name="client_type" value="{{$client->client_type}}">
    <div class="row">
    @if($client->client_type == 0)
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="fname" class="form-control mb-3" placeholder="Фамилия" value="{{$client->fname}}">
                </div>
                <div class="col-md-4">
                    <input type="text" name="lname" class="form-control mb-3" placeholder="Имя" value="{{$client->lname}}">
                </div>
                <div class="col-md-4">
                    <input type="text" name="mname" class="form-control mb-3" placeholder="Отчество" value="{{$client->mname}}">
                </div>
                <div class="col-md-4">
                    <input type="date" name="dbirth" class="form-control mb-3" placeholder="Дата рождения" value="{{$client->dbirth}}">
                </div>
                <div class="col-md-4">
                    <input type="text" name="occupation" class="form-control mb-3" placeholder="Профессия" value="{{$client->occupation}}">
                </div>
            </div>
        </div>
    @else
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="inn" class="form-control mb-3" placeholder="ИНН" value="{{$client->inn}}">
                </div>
                <div class="col-md-4">
                    <input type="text" name="company_name" class="form-control mb-3" placeholder="Название компании" value="{{$client->company_name}}">
                </div>
            </div>
        </div>
    @endif
        <div class="col-md-4">
            <input type="text" name="phone_number" class="form-control mb-3" placeholder="Номер телефона" value="{{$client->phone_number}}">
        </div>
        <div class="col-md-12 mb-5">
            <label>Область</label><br>
            <select name="region" class="form-control">
                @foreach($regions as $index=>$region)
                    <option value="{{$index}}" {{ $client->region == $index ? 'selected':'' }}>{{ $region }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <button class="btn btn-success btn-sm font-weight-bold">save</button>
</form>

</div>

@endsection
