<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string|min:7',
            'new_password' => 'required|string|min:7',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'A senha atual está incorreta.']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        $request->session()->regenerate();

        return redirect()->route('account.profile')->with('success', 'Senha alterada com sucesso!');
    }
}
