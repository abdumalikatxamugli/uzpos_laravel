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
            </tbody>
        </table>
    </div>
@endsection
