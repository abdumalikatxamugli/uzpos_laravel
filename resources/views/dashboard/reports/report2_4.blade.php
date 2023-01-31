@extends('layouts.app')

@section('content')

    <div class="card-header-primary d-flex justify-content-between">
        Отчеты по продажам - по рознице ( 2.4 ) 
        <a href="{{route('dashboard.report_2_4_download')}}" class="btn btn-primary bg-white text-primary">
            <i class="material-icons">download</i>
        </a>
    </div>
    <div class="card-body">
        <table class="table table-hover text-center">
            <thead>
            						

                <tr class="text-secondary ">
                    <th>
                        <small>
                        ТОЧКА
                        </small>
                    </th>
                    <th>
                        <small>
                        НАИМЕНОВАНИЕ
                        </small>
                    </th>
                    <th>
                        <small>
                         ШТ
                        </small>
                    </th>
                    <th>
                        <small>
                        ШТРИХ-КОД
                        </small>
                    </th>
                    <th>
                        <small>   
                        СУММА
                        </small>
                    </th>
                    <th>
                        <small>   
                        ДАТА
                        </small>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($result as $r)
                <tr>
                    <td>{{$r->point_name}}</td>
                    <td>{{$r->product_name}}</td>
                    <td>{{$r->total_quantity}}</td>
                    <td>{{$r->bar_code}}</td>
                    <td>{{$r->total_price}}</td>
                    <td>{{$r->order_day}}</td>               
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection