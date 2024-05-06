<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        return view('user.account', [
            'title' => 'Minha conta | DanBlog',
            'user' => $user
        ]);
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();

        $validationRule = [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ];

        if ($request->email !== $user->email) {
            $validationRule['email'] = 'required|email|unique:users';
        }

        $validator = Validator::make($request->all(), $validationRule);

        if ($validator->fails()) {
            return redirect()->route('account.profile')->withErrors($validator)->withInput();
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('account.profile')->with('success', 'Dados atualizado com sucesso.');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            if (!empty($user->avatar)) {
                $oldAvatarPath = public_path('storage/' . $user->avatar);
                
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath);
                }
            }

            $avatarPath = $request->file('avatar')->store('avatars');

            $user->avatar = $avatarPath;
            $user->save();
        }

        return redirect()->route('account.profile')->with('success', 'Foto de perfil atualizada com sucesso.');
    }

    public function destroy()
    {
        Auth::user()->delete();
        Auth::logout();

        return redirect()->route('home');
    }
}
