<!DOCTYPE html>
<html>
<head><title>New Submission</title></head>
<body>
    <h2>New Submission</h2>
    <form method="POST" action="/submissions">
        @csrf
        <input type="text" name="title" placeholder="Title" required><br>
        <textarea name="description" placeholder="Description" required></textarea><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
