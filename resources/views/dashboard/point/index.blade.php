<a href="{{ route('dashboard.point.create') }}"> Create </a>
<table border="1">
    <thead>
        <tr>
            <th>Name</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($points as $point)
            <tr>
                <td>{{$point->name}}</td>
                <td><a href="{{ route('dashboard.point.edit', $point->id) }}">Edit</a></td>
                <td>
                    <form action="{{ route('dashboard.point.destroy', $point->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button>Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
