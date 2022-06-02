@extends('layouts.app')

@section('content')
    @if($is_warehouse)
    <div class="card-body">
        <h2 class="mb-5">Отчеты для складчика</h2>
        <table class="table table-hover" border="1">
            <tbody>
                <tr>
                    <td class="p-0">
                        <a href="{{ route('dashboard.reports.goods') }}" class="d-block p-1">
                            Остаток товаров ( по брендам/категориям )
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="{{ route('dashboard.reports.runout') }}" class="d-block p-1">
                            Заканчивающиеся товары
                        </a>
                    </td>                    
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="{{ route('dashboard.reports.goodsByDivision') }}" class="d-block p-1">
                            Отчет товаров по магазинам
                        </a>
                    </td>                    
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="{{ route('dashboard.reports.salesByProduct') }}" class="d-block p-1">
                            Расход продуктов(Оптом / Розничный)
                        </a>
                    </td>                    
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="{{ route('dashboard.reports.esfByPeriod') }}" class="d-block p-1">
                            Счет-фактуры
                        </a>
                    </td>                    
                </tr>
            </tbody>
        </table>
    </div>
    @endif
    @if($is_seller)
    <div class="card-body">
        <h2 class="mb-5">Отчеты для магазина</h2>
        <table class="table table-hover" border="1">
            <tbody>
                <tr>
                    <td class="p-0">
                        <a href="{{ route('dashboard.reports.goods') }}" class="d-block p-1">
                            Остаток товара в магазине ( по брендам/категориям )
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="{{ route('dashboard.reports.runout') }}" class="d-block p-1">
                            Заканчивающиеся товары в магазине 
                        </a>
                    </td>                    
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="{{ route('dashboard.reports.esfByPeriod') }}" class="d-block p-1">
                            Список счет-фактур(только текуший магазин)
                        </a>
                    </td>                    
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="{{ route('dashboard.reports.debts') }}" class="d-block p-1">
                            Список долгов клиентов
                        </a>
                    </td>                    
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="{{ route('dashboard.reports.expenses') }}" class="d-block p-1">
                            Расход магазина
                        </a>
                    </td> 
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="{{ route('dashboard.reports.salesByOrderType') }}" class="d-block p-1">
                            Продажа магазина (Оптом / Розничный)
                        </a>
                    </td>                    
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="{{ route('dashboard.reports.salesByProduct') }}" class="d-block p-1">
                            Продажа магазина по продуктам(Оптом / Розничный)
                        </a>
                    </td>                    
                </tr>
                
                
            </tbody>
        </table>
    </div>
    @endif
    @if($is_admin)
    <div class="card-body">
        <h2 class="mb-5">Отчеты (Главный)</h2>
        <table class="table table-hover" border="1">
            <tbody>
                <tr>
                    <td class="p-0">
                        <a href="{{ route('dashboard.reports.goods') }}" class="d-block p-1">
                            Остаток по товарам (Имеющиеся/Заканчивающиеся/ по брендам/категориям )
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="{{ route('dashboard.reports.salesByPoint') }}" class="d-block p-1">
                            Отчет по продаже(по периоду/по магазину) 
                        </a>
                    </td>                    
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="{{ route('dashboard.reports.clients') }}" class="d-block p-1">
                            Статистика по клиентам(по заказам/по обёму)
                        </a>
                    </td>                    
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="{{ route('dashboard.reports.esfByPeriod') }}" class="d-block p-1">
                            Cчет-фактур(по номеру/по периоду/по клиенту)
                        </a>
                    </td>                    
                </tr>
            </tbody>
        </table>
    </div>
    @endif
@endsection
