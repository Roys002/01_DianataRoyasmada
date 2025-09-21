@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow">
                <div class="card-header">
                    <h4>Submission Detail</h4>
                </div>

                <div class="card-body">
                    <p><strong>ID:</strong> {{ $submission->id }}</p>
                    <p><strong>User:</strong> {{ $submission->user->name }}</p>
                    <p><strong>Title:</strong> {{ $submission->title }}</p>
                    <p><strong>Description:</strong> {{ $submission->description }}</p>
                    <p>
                        <strong>Status:</strong>
                        <span class="badge 
                            @if($submission->status === 'pending') bg-warning 
                            @elseif($submission->status === 'verified') bg-success 
                            @elseif($submission->status === 'processing') bg-info 
                            @elseif($submission->status === 'completed') bg-primary 
                            @elseif($submission->status === 'rejected') bg-danger 
                            @endif">
                            {{ ucfirst($submission->status) }}
                        </span>
                    </p>

                    {{-- Kalau ada lampiran --}}
                    @if($submission->attachment)
                    <p>
                        <strong>Attachment:</strong>
                        <a href="{{ asset('storage/'.$submission->attachment) }}" target="_blank">
                            Lihat File
                        </a>
                    </p>
                    @endif
                </div>

                <div class="card-footer d-flex gap-2">
                    {{-- Approve (verified) --}}
                    <form action="{{ route('admin.submissions.updateStatus', $submission->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="verified">
                        <button class="btn btn-success btn-sm">Verified</button>
                    </form>

                    {{-- Processing --}}
                    <form action="{{ route('admin.submissions.updateStatus', $submission->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="processing">
                        <button class="btn btn-info btn-sm text-white">Processing</button>
                    </form>

                    {{-- Completed --}}
                    <form action="{{ route('admin.submissions.updateStatus', $submission->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="completed">
                        <button class="btn btn-primary btn-sm">Completed</button>
                    </form>

                    {{-- Reject --}}
                    <form action="{{ route('admin.submissions.updateStatus', $submission->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="rejected">
                        <button class="btn btn-danger btn-sm">Reject</button>
                    </form>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('admin.submissions.index') }}" class="btn btn-secondary">⬅ Back to Dashboard</a>
            </div>

        </div>
    </div>
</div>
@endsection