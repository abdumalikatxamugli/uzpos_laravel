<a href="{{ route('dashboard.metric.create') }}"> Create </a>
<table border="1">
    <thead>
        <tr>
            <th>Name</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($metrics as $metric)
            <tr>
                <td>{{$metric->name}}</td>
                <td><a href="{{ route('dashboard.metric.edit', $metric->id) }}">Edit</a></td>
                <td>
                    <form action="{{ route('dashboard.metric.destroy', $metric->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button>Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
