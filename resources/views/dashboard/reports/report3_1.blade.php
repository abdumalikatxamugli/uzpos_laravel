@extends('layouts.app')

@section('content')

    <div class="card-header-primary d-flex justify-content-between">
        Отчёты по клиентам - Клиенты (3.1)
        <a href="{{route('dashboard.report_3_1_download')}}" class="btn btn-primary bg-white text-primary">
            <i class="material-icons">download</i>
        </a>
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