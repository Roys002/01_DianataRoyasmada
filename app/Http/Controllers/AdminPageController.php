<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Submission;
use App\Models\SubmissionLog;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminPageController extends Controller
{
    public function showLoginForm(){
        return view('admin.login');
    }

    public function login(Request $request){
        $data = $request->validate([
            'email'=>'required|email',
            'password'=>'required|string'
        ]);

        $user = User::where('email',$data['email'])->first();
        if (! $user || ! Hash::check($data['password'],$user->password) || $user->role !== 'admin') {
            return back()->withErrors(['email'=>'Email/password salah, atau bukan admin'])->onlyInput('email');
        }

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('admin.submissions.index');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login.form')->with('success','Logout berhasil');
    }

    public function index(Request $request){
        // support filter by status or type via query string
        $q = Submission::with('user')->latest();
        if ($request->filled('status')) $q->where('status',$request->status);
        if ($request->filled('type')) $q->where('type',$request->type);

        // $submissions = $q->paginate(20)->withQueryString();
        return view('admin.submissions.index', compact('submissions'));
    }

    public function show($id){
        $submission = Submission::with('logs','user')->findOrFail($id);
        return view('admin.submissions.show', compact('submission'));
    }

    public function updateStatus(Request $request, $id){
        $data = $request->validate([
            'status'=>'required|in:pending,verified,rejected,processing,completed',
            'admin_note'=>'nullable|string'
        ]);

        $submission = Submission::findOrFail($id);
        $submission->update([
            'status'=>$data['status'],
            'admin_note'=>$data['admin_note'] ?? $submission->admin_note,
        ]);

        SubmissionLog::create([
            'submission_id'=>$submission->id,
            'admin_id'=>auth()->id(),
            'status'=>$data['status'],
            'note'=>$data['admin_note'] ?? null
        ]);

        return redirect()->route('admin.submissions.show', $id)->with('success','Status diperbarui.');
    }
}
