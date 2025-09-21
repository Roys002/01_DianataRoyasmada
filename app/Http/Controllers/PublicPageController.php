<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Submission;
use App\Models\SubmissionLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PublicPageController extends Controller
{
    public function showRegisterForm(){
        return view('public.register');
    }

    public function register(Request $request){
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),
            'role'=>'user'
        ]);

        Auth::login($user);

        return redirect()->route('submissions.index')->with('success','Registrasi berhasil. Selamat datang!');
    }

    public function showLoginForm(){
        return view('public.login');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=>'required|string'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('submissions.index'));
        }

        return back()->withErrors(['email'=>'Email atau password salah'])->onlyInput('email');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.form')->with('success','Anda telah logout.');
    }

    public function profile(){
        return view('public.profile', ['user'=>auth()->user()]);
    }

    // list user's submissions
    public function index(){
        $submissions = auth()->user()->submissions()->latest()->paginate(10);
        return view('public.submissions.index', compact('submissions'));
    }

    public function create(){
        return view('public.submissions.create');
    }

    public function store(Request $request){
        $data = $request->validate([
            'title'=>'required|string|max:191',
            'description'=>'required|string',
            'type'=>'nullable|string|max:100',
            'attachment'=>'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120'
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attachments','public');
        }

        $data['user_id'] = auth()->id();
        $data['status'] = 'pending';

        $submission = Submission::create($data);

        SubmissionLog::create([
            'submission_id'=>$submission->id,
            'admin_id'=>null,
            'status'=>$submission->status,
            'note'=>'Dibuat oleh pemohon'
        ]);

        return redirect()->route('submissions.index')->with('success','Pengajuan berhasil dikirim.');
    }

    public function show($id){
        $submission = Submission::with('logs')->findOrFail($id);
        // authorisasi: hanya pemilik (atau admin jika perlu)
        if ($submission->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }
        return view('public.submissions.show', compact('submission'));
    }
}
