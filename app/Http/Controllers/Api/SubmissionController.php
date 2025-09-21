<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubmissionRequest;
use App\Models\Submission;
use App\Models\SubmissionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    // buat pengajuan (public access)
    public function store(StoreSubmissionRequest $request)
    {
        // jika user terdaftar via token, gunakan user; 
        // tapi karena public registrasi, kita akan support guest => must attach email? 
        // Simpler: require auth for submission OR require email/phone fields.
        // Di sini asumsikan user sudah register/login (token), jadi:
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please login or register.'], 401);
        }

        $data = $request->validated();
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
            $data['attachment'] = $path;
        }

        $data['user_id'] = $user->id;
         $data['status'] = 'pending';

        $submission = Submission::create($data);

        // buat log awal
        SubmissionLog::create([
            'submission_id' => $submission->id,
            'admin_id' => null,
            'status' => $submission->status,
            'note' => 'Created by user'
        ]);

        return response()->json($submission, 201);
    }

    // daftar pengajuan milik user (pemantauan status)
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user) return response()->json([], 401);

        $submissions = Submission::where('user_id', $user->id)->latest()->paginate(10);
        return response()->json($submissions);
    }

    // lihat detail pengajuan
    public function show($id, Request $request)
    {
        $user = $request->user();
        $submission = Submission::with('logs')->findOrFail($id);
        if ($submission->user_id !== $user->id && !$user->isAdmin()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        return response()->json($submission);
    }
}
