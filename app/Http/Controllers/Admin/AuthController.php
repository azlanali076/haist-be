<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(){
        return view('admin.auth.login');
    }

    public function doLogin(Request $request){
        $validated = $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required'
        ]);
        $user = User::where(['email' => $request->email])->first();
        if($user->role->name != config('constants.roles.haist_admin') and $user->role->name != config('constants.roles.admin') and $user->role->name != config('constants.roles.manager')){
            return redirect()->back()->withInput($validated)->withErrors(['email' => ['The selected email is invalid!']]);
        }
        if(Auth::attempt($validated)){
            session()->flash('success','Login Success!');
            return redirect(route('home'));
        }
        else{
            session()->flash('error','Email or Password is incorrect!');
            return redirect(route('auth.login'));
        }
    }

    public function logout(){
        Auth::logout();
        return redirect(route('auth.login'));
    }
}
