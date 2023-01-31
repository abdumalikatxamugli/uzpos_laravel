@extends('layouts.app')

@section('content')

    <div class="card-header-primary d-flex justify-content-between">
        Отчеты по продажам - расходы ( 2.5 ) 
        <a href="{{route('dashboard.report_2_5_download')}}" class="btn btn-primary bg-white text-primary">
            <i class="material-icons">download</i>
        </a>
    </div>
    <div class="card-body">
        <table class="table table-hover text-center">
            <thead>
            						

                <tr class="text-secondary ">
                    <th>
                        <small>
                        КАССА
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
                    <td>{{$r->total_sum}}</td>
                    <td>{{$r->expense_day}}</td>           
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection