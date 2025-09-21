<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index()
    {
        $submissions = Submission::with('user')->latest()->get();
        return view('admin.submissions.index', compact('submissions'));
    }

    public function show($id)
    {
        $submission = Submission::with('user')->findOrFail($id);
        return view('admin.submissions.show', compact('submission'));
    }

    public function updateStatus(Request $request, $id)
    {
        $submission = Submission::findOrFail($id);

        $data = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $submission->status = $data['status'];
        $submission->save();

        return redirect()->route('admin.dashboard')->with('success', 'Status updated.');
    }
}
