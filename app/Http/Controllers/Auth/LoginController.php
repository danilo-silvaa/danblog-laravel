<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login', [
            'title' => 'Login | DanBlog'
        ]);
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:7',
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            
            return response()->json(['success' => true, 'redirect' => '/account']);
        }
        
        return response()->json(['success' => false, 'error' => 'E-mail ou senha inválidos.'], 401);
    }
}
