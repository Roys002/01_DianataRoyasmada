<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSubmissionStatusRequest;
use App\Models\Submission;
use App\Models\SubmissionLog;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $submissions = Submission::with('user')->latest()->paginate(20);
        return response()->json($submissions);
    }

    public function show($id)
    {
        $submission = Submission::with('logs','user')->findOrFail($id);
        return response()->json($submission);
    }

    public function updateStatus($id, UpdateSubmissionStatusRequest $request)
    {
        $submission = Submission::findOrFail($id);
        $data = $request->validated();

        $submission->update([
            'status' => $data['status'],
            'admin_note' => $data['admin_note'] ?? $submission->admin_note
        ]);

        // Simpan log
        SubmissionLog::create([
            'submission_id' => $submission->id,
            'admin_id' => $request->user()->id,
            'status' => $data['status'],
            'note' => $data['admin_note'] ?? null
        ]);

        // optional: kirim notifikasi ke pemohon (email / notification)
        return response()->json(['message'=>'Status updated','submission'=>$submission]);
    }
}
