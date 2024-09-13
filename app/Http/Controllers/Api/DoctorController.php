<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index(){
        $role = Role::where(['name' => config('constants.roles.doctor')])->firstOrFail();
        $doctors = User::where(['facility_id' => request()->user()->facility_id,'role_id' => $role->id])->get();
        return $this->success('Got Doctors',$doctors);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|confirmed|unique:users,email'
        ]);
        $role = Role::where(['name' => config('constants.roles.doctor')])->firstOrFail();
        $validated['facility_id'] = $request->user()->facility_id;
        $validated['password'] = Hash::make('Welcome123');
        $validated['role_id'] = $role->id;
        $doctor = User::create($validated);
        return $this->success('Doctor Added!',$doctor);
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|confirmed',
        ]);
        $role = Role::where('name','=',config('constants.roles.doctor'))->firstOrFail();
        $doctor = User::where(['role_id' => $role->id])->findOrFail($id);
        $doctor->update($validated);
        $doctor = User::findOrFail($doctor->id);
        return $this->success('Doctor Updated!',$doctor);
    }

    public function destroy($id){
        $role = Role::where('name','=',config('constants.roles.doctor'))->firstOrFail();
        $doctor = User::where(['role_id' => $role->id])->findOrFail($id);
        $doctor->delete();
        return $this->success('Doctor Deleted!');
    }
}
