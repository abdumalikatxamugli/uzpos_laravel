@extends($popup?'layouts.appWithoutSidebar':'layouts.app')

@section('content')

<div class="card-header-primary">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="m-0">Clients</h3>
        <a href="{{ route_with_query_params('dashboard.client.create') }}" class="btn btn-white btn-sm text-primary font-weight-bold">
            Create 
        </a>
    </div>
</div>
<div class="card-body  px-0 pt-0 pb-2">
    <table class="table text-center mt-5">
        <thead>
            <tr>
                <th>#</th>
                <th width="80%">Название</th>
                <th></th>
                <th></th>
                @if(!$popup)
                    <th class="text-uppercase text-secondary"></th>
                @endif
                @if($popup)
                    <th class="text-uppercase text-secondary">Выбрать</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $number => $client)
                <tr>
                    <td>{{$number+1}}</td>
                    <td class="mb-0 text-sm">{{$client->client_type == 0 ? $client->first_name . ' ' . $client->last_name . ' ' . $client->middle_name : $client->company_name}}</td>
                    <td>
                        <a href="{{ route('debt.client.index', $client) }}" target="_blank" class="btn btn-success btn-sm mb-0">
                            <i class="material-icons">paid</i>
                        </a>
                    </td>
                    <td class="mb-0 text-sm">
                        <a href="{{ route('dashboard.client.edit', $client->id) }}" class="btn btn-warning btn-sm">
                            <i class="material-icons">edit</i>
                        </a>
                    </td>                        
                    @if(!$popup)                     
                    <td class="mb-0 text-sm">
                        @if(!$client->chat)
                            <form action="{{ route('dashboard.client.destroy', $client->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm ">Удалить</button>
                            </form>
                        @endif
                    </td>
                    @endif
                    @if($popup)
                    <td class="mb-0 text-sm">
                        <a href="{{ route('dashboard.client.append.order', ['order'=>$order, 'client'=>$client]) }}" class="btn btn-success btn-sm">
                            Выбрать
                        </a>
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $clients->withQueryString()->links() }}
</div>

@endsection
