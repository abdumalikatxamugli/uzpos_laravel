<a href="{{ route('dashboard.client.create') }}"> Create </a>
<table border="1">
    <thead>
        <tr>
            <th>Name</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clients as $client)
            <tr>
                <td>{{$client->name}}</td>
                <td><a href="{{ route('dashboard.client.edit', $client->id) }}">Edit</a></td>
                <td>
                    <form action="{{ route('dashboard.client.destroy', $client->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button>Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
