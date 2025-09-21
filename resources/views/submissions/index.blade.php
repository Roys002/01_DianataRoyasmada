<!DOCTYPE html>
<html>
<head><title>Dashboard</title></head>
<body>
    <h2>My Submissions</h2>
    <a href="/submissions/create">Create Submission</a> |
    <form method="POST" action="/logout" style="display:inline">
        @csrf
        <button type="submit">Logout</button>
    </form>
    <ul>
        @foreach($submissions as $s)
            <li>{{ $s->title }} - {{ $s->status }}</li>
        @endforeach
    </ul>
</body>
</html>
