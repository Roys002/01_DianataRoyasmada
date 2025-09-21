<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Login khusus admin
     */
     public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            Auth::logout();
            return back()->withErrors(['email' => 'You are not authorized as admin']);
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    // public function login(Request $request)
    // {
    //     $validated = $request->validate([
    //         'email'    => 'required|string|email',
    //         'password' => 'required|string',
    //     ]);

    //     $user = User::where('email', $validated['email'])->first();

    //     if (! $user || ! Hash::check($validated['password'], $user->password)) {
    //         throw ValidationException::withMessages([
    //             'email' => ['Email atau password salah.'],
    //         ]);
    //     }

    //     // Cek apakah role admin
    //     if ($user->role !== 'admin') {
    //         return response()->json([
    //             'message' => 'Hanya admin yang bisa login di endpoint ini.'
    //         ], 403);
    //     }

    //     // Buat token admin
    //     $token = $user->createToken('admin_token')->plainTextToken;

    //     return response()->json([
    //         'message' => 'Login admin berhasil',
    //         'user'    => $user,
    //         'token'   => $token,
    //     ]);
    // }

    /**
     * Logout admin
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout admin berhasil, token dihapus'
        ]);
    }
}
