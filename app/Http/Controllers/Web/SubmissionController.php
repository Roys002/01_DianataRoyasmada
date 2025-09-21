<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    public function index()
    {
        $submissions = Submission::where('user_id', Auth::id())->get();
        return view('submissions.index', compact('submissions'));
    }

    public function create()
    {
        return view('submissions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Submission::create([
            'user_id'     => Auth::id(),
            'title'       => $data['title'],
            'description' => $data['description'],
            'status'      => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Submission created.');
    }
}

