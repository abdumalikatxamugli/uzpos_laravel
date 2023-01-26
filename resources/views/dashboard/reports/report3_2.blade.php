@extends('layouts.app')

@section('content')

    <div class="card-header-primary">
        Отчёты по клиентам - Долги клиенты (3.2)
    </div>
    <div class="card-body">
        <table class="table table-hover text-center">
            <thead>
                <tr class="text-secondary ">
                    <th>
                        <small>
                        ИМЯ
                        </small>
                    </th>
                    <th>
                        <small>
                        ID
                        </small>
                    </th>
                    <th>
                        <small>
                        РЕГИОН
                        </small>
                    </th>
                    <th>
                        <small>
                        КОНТАКТ
                        </small>
                    </th>
                    <th>
                        <small>
                        СУММА ДОЛГА
                        </small>
                    </th>
                    <th>
                        <small>
                        ДАТА
                        </small>
                    </th>
                    <th>
                        <small>
                        ТОЧКА ПРОДАЖ
                        </small>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($result as $r)
                <tr>
                    <td>{{$r->client_name}}</td>
                    <td>{{$r->id}}</td>
                    <td>{{$r->region_id??'-'}}</td>
                    <td>{{$r->phone_number ?? '-'}}</td>  
                    <td>{{$r->amount }}</td>   
                    <td>{{$r->order_day }}</td>   
                    <td>{{$r->point_name }}</td>             
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection