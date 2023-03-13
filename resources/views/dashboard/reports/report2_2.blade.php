@extends('layouts.app')

@section('content')

    <div class="card-header-primary d-flex justify-content-between">
        Отчеты по продажам - Список Счёт-фактур ( 2.2 ) 
        <a href="{{route('dashboard.report_2_2_download')}}" class="btn btn-primary bg-white text-primary">
            <i class="material-icons">download</i>
        </a>
    </div>
    <div class="card-body">
        <table class="table table-hover text-center">
            <thead>
            						

                <tr class="text-secondary ">
                    <th>
                        <small>
                        Номер
                        </small>
                    </th>
                    <th>
                        <small>
                        Сумма
                        </small>
                    </th>
                    <th>
                        <small>
                        дата
                        </small>
                    </th>
                    <th>
                        <small>
                        ID клиента
                        </small>
                    </th>
                    <th>
                        <small>
                        Имя клиента
                        </small>
                    </th>
                    <th>
                        <small>   
                        Инфо
                        </small>
                    </th>
                    <th>
                        <small>   
                        Точка заказа
                        </small>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($result as $r)
                <tr>
                    <td>{{$r->esf_no}}</td>
                    <td>{{$r->total_sum}}</td>
                    <td>{{$r->created_date}}</td>
                    <td>{{$r->client_id}}</td>
                    <td>{{$r->client_name}}</td>
                    <td>{{$r->region}}</td>   
                    <td>{{$r->point_name}}</td>                 
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection