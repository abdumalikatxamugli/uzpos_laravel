@extends('layouts.app')

@section('content')
    <div class="card-body">
        <h2 class="mb-5">Отчеты</h2>
        <table class="table table-hover" border="1">
            <tbody>
                <tr>
                    <td class="p-0">
                        <a href="{{ route('dashboard.reports.goods') }}" class="d-block p-1">
                            Остаток товаров
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="#" class="d-block p-1">
                            Заканчивающиеся товары
                        </a>
                    </td>                    
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="#" class="d-block p-1">
                            Отчет товаров по магазинам
                        </a>
                    </td>                    
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="#" class="d-block p-1">
                            Расход продуктов(Оптом / Розничный)
                        </a>
                    </td>                    
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="#" class="d-block p-1">
                            Счет-фактуры
                        </a>
                    </td>                    
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="#" class="d-block p-1">
                            Список долгов клиентов
                        </a>
                    </td>                    
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="#" class="d-block p-1">
                            Расход магазина
                        </a>
                    </td>                    
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="#" class="d-block p-1">
                            Статистика по дням/месяцам/годам
                        </a>
                    </td>                    
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="#" class="d-block p-1">
                            Статистика по магазинам
                        </a>
                    </td>                    
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="#" class="d-block p-1">
                            Статистика по расходам
                        </a>
                    </td>                    
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="#" class="d-block p-1">
                            Статистика по клиентам - по заказам
                        </a>
                    </td>                    
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="#" class="d-block p-1">
                            Статистика по клиентам - по обёму
                        </a>
                    </td>                    
                </tr>
                <tr>
                    <td class="p-0">
                        <a href="#" class="d-block p-1">
                            Счет фактура - по данному периоду
                        </a>
                    </td>                    
                </tr>
            </tbody>
        </table>
    </div>
@endsection
