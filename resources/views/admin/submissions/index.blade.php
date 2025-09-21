<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title></head>
<body>
    <h2>All Submissions</h2>
    <form method="POST" action="/admin/logout" style="display:inline">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Title</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        @foreach($submissions as $s)
        <tr>
            <td>{{ $s->id }}</td>
            <td>{{ $s->user->name }}</td>
            <td>{{ $s->title }}</td>
            <td>{{ $s->status }}</td>
            <td>
                <a href="{{ route('admin.submissions.show', $s->id) }}">View</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>
