@extends('layouts.app')

@section('content')

    <div class="card-header-primary d-flex justify-content-between">
        Отчеты по продажам - по Кассам ( 2.1 ) 
        <a href="{{route('dashboard.report_2_1_download')}}" class="btn btn-primary bg-white text-primary">
            <i class="material-icons">download</i>
        </a>
    </div>
    <div class="card-body">
        <table class="table table-hover text-center">
            <thead>
                <tr class="text-secondary ">
                    <th>
                        <small>
                            КАССА ТОЧКЕ
                        </small>
                    </th>
                    <th>
                        <small>
                            ДАТА
                        </small>
                    </th>
                    <th>
                        <small>
                            ОБШИЙ СУММА
                        </small>
                    </th>
                    <th>
                        <small>
                            РАСХОД
                        </small>
                    </th>
                    <th>
                        <small>
                            СУМ
                        </small>
                    </th>
                    <th>
                        <small>   
                            ДОЛЛАР
                        </small>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($result as $r)
                <tr>
                    <td>{{$r->point_name}}</td>
                    <td>{{$r->created_date}}</td>
                    <td>{{$r->total_cost}}</td>
                    <td>{{$r->total_expense}}</td>
                    <td>{{$r->uzs_payment}}</td>
                    <td>{{$r->usd_payment}}</td>                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection