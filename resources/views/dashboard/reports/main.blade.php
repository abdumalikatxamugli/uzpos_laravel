@extends('layouts.app')

@section('content')
    <style>
        .report-header{
            text-align: center;
        }
        .report-header i{
            font-size: 80px;
        }
    </style>
    <div class="card-header-primary mb-5">
        <h3 class="m-0">Отчеты (Главный)</h3>
    </div>
    <div class="card-body pt-3">
        <h3 class="text-secondary">Отчеты по продаже</h3>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header pt-3">
                        <div class="report-header">
                            <i class="material-icons">document_scanner</i>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <hr>
                        <a class="text-primary text-title" href="{{route('dashboard.report_2_1')}}">
                            <h4>КАССА (2.1)</h4>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header pt-3">
                        <div class="report-header">
                            <i class="material-icons">document_scanner</i>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <hr>
                        <a class="text-primary text-title" href="{{route('dashboard.report_2_2')}}">
                            <h4>Счёт-фактуры (2.2)</h4>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header pt-3">
                        <div class="report-header">
                            <i class="material-icons">document_scanner</i>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <hr>
                        <a class="text-primary text-title" href="{{route('dashboard.report_2_3')}}">
                            <h4>Отчёт по рознице (2.3)</h4>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header pt-3">
                        <div class="report-header">
                            <i class="material-icons">document_scanner</i>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <hr>
                        <a class="text-primary text-title" href="{{route('dashboard.report_2_4')}}">
                            <h4>Отчёт по рознице (ДЕТАЛЬНЫЙ) (2.4)</h4>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header pt-3">
                        <div class="report-header">
                            <i class="material-icons">document_scanner</i>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <hr>
                        <a class="text-primary text-title" href="{{route('dashboard.report_2_5')}}">
                            <h4>Расходы (2.5)</h4>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
