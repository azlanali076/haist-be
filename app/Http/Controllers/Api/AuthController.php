<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Avatar;
use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Mockery\Generator\StringManipulation\Pass\Pass;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required'
        ]);
        $role = Role::where(['name' => config('constants.roles.nurse')])->firstOrFail();
        $anotherRole = Role::where(['name' => config('constants.roles.assistant_nurse')])->firstOrFail();
        $user = User::where(['email' => $request->email])->whereIn('role_id',[$role->id,$anotherRole->id])->first();
        if($user){
            if(Hash::check($request->password,$user->password)){
                $token = $user->createToken('Login');
                return $this->success('Login Success',['user' => $user,'token' => $token->plainTextToken]);
            }
            return $this->error('Email or Password is Incorrect!',[], ResponseAlias::HTTP_UNAUTHORIZED);
        }
        return $this->error('The selected email is invalid.',[],422);
    }

    public function register(Request $request){
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'dob' => 'required|date',
            'role_id' => 'required|exists:roles,id'
        ]);
        $userData = $request->except(['password']);
        $userData['password'] = Hash::make($request->password);
        $userData['avatar'] = Avatar::generateAvatar($request->first_name.' '.$request->last_name);
        $user = User::create($userData);
        UserRole::create([
            'user_id' => $user->id,
            'role_id' => $request->role_id
        ]);
        return $this->success('Registered Successfully!');
    }

    public function forgotPassword(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);
        $nurseRole = Role::where(['name' => config('constants.roles.nurse')])->firstOrFail();
        $otp = rand(1111,9999);
        User::where(['email' => $request->email,'role_id' => $nurseRole->id])->update(['otp' => $otp]);
        $user = User::where(['email' => $request->email,'role_id' => $nurseRole->id])->firstOrFail();
        Mail::to($request->email)->send(new ForgotPassword($user,$otp));
        return $this->success('Forgot Password Email Sent!');
    }

    public function resetPassword(Request $request){
        $request->validate([
            'otp' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed'
        ]);
        $nurseRole = Role::where(['name' => config('constants.roles.nurse')])->firstOrFail();
        $user = User::where(['email' => $request->email,'role_id' => $nurseRole->id])->firstOrFail();
        if($user->otp === $request->otp) {
            $user->update(['password' => Hash::make($request->password)]);
            return $this->success('Password Reset Successfully!');
        }
        else{
            return $this->error('Invalid OTP');
        }
    }
}
