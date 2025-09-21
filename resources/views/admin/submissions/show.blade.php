<!DOCTYPE html>
<html>
<head><title>Submission Detail</title></head>
<body>
    <h2>Submission #{{ $submission->id }}</h2>
    <p><strong>User:</strong> {{ $submission->user->name }}</p>
    <p><strong>Title:</strong> {{ $submission->title }}</p>
    <p><strong>Description:</strong> {{ $submission->description }}</p>
    <p><strong>Status:</strong> {{ $submission->status }}</p>

    <form method="POST" action="{{ route('admin.submissions.updateStatus', $submission->id) }}">
        @csrf
        @method('PATCH')
        <select name="status">
            <option value="pending" @selected($submission->status === 'pending')>Pending</option>
            <option value="approved" @selected($submission->status === 'approved')>Approved</option>
            <option value="rejected" @selected($submission->status === 'rejected')>Rejected</option>
            <option value="processing" @selected($submission->status === 'processing')>Processing</option>
            <option value="completed" @selected($submission->status === 'completed')>Completed</option>
        </select>
        <button type="submit">Update Status</button>
    </form>

    <p><a href="{{ route('admin.dashboard') }}">Back to Dashboard</a></p>
</body>
</html>
