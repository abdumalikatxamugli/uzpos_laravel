@extends($popup?'layouts.appWithoutSidebar':'layouts.app')

@section('content')

@include('partials.validation_errors')

<div class="card-body">

<form action="{{ route_with_query_params('dashboard.client.update', $client->id) }}" method="POST" x-data="{}">
    @method('PUT')
    @csrf
    <input type="hidden" name="client_type" value="{{$client->client_type}}">
    <div class="row">
    @if($client->client_type == 0)
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="first_name" class="form-control mb-3" placeholder="Фамилия" value="{{$client->first_name}}">
                </div>
                <div class="col-md-4">
                    <input type="text" name="last_name" class="form-control mb-3" placeholder="Имя" value="{{$client->last_name}}">
                </div>
                <div class="col-md-4">
                    <input type="text" name="middle_name" class="form-control mb-3" placeholder="Отчество" value="{{$client->middle_name}}">
                </div>
                <div class="col-md-4">
                    <input type="date" name="date_birth" class="form-control mb-3" placeholder="Дата рождения" value="{{$client->date_birth}}">
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
            <input type="text" name="phone_number" class="form-control mb-3" placeholder="Номер телефона" value="{{$client->phone_number}}" x-mask="(99)-999-99-99">
        </div>
        <div class="col-md-12 mb-5">
            <label>Область</label><br>
            <select name="region_id" class="form-control">
                @foreach($regions as $index=>$region)
                    <option value="{{$index}}" {{ $client->region_id == $index ? 'selected':'' }}>{{ $region }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <button class="btn btn-success btn-sm font-weight-bold">
        <i class="material-icons">check</i>
    </button>
</form>

</div>

@endsection
