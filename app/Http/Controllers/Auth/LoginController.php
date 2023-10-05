<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();
        if($user)
        {

            if(Hash::check($data['password'], $user->password))
            {
                Auth::login($user);
                return redirect()->route('admin.index');
            }
            return back()->withErrors(['password' => 'incorrect password']);
        }
        return back()->withErrors(['email' => 'user not found']);

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
