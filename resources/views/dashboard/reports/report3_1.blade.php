@extends('layouts.app')

@section('content')

    <div class="card-header-primary">
        Отчёты по клиентам - Клиенты (3.1)
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
                </tr>
            </thead>
            <tbody>
                @foreach($result as $r)
                <tr>
                    <td>{{$r->client_name}}</td>
                    <td>{{$r->id}}</td>
                    <td>{{$r->region_id??'-'}}</td>
                    <td>{{$r->phone_number ?? '-'}}</td>            
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection