<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{

    private $fields = [
        [
            'label' => 'First name',
            'name' => 'first_name',
            'id' => 'first_name',
            'placeholder' => 'Enter First name',
            'required' => true,
            'options' => []
        ],
        [
            'label' => 'Last name',
            'name' => 'last_name',
            'id' => 'last_name',
            'placeholder' => 'Enter Last name',
            'required' => true,
            'options' => []
        ],
        [
            'label' => 'Email',
            'name' => 'email',
            'id' => 'email',
            'placeholder' => 'Enter Email',
            'type' => 'email',
            'required' => true,
            'options' => []
        ],
        [
            'label' => 'Confirm Email',
            'name' => 'email_confirmation',
            'id' => 'email_confirmation',
            'placeholder' => 'Enter Confirm Email',
            'required' => true,
            'options' => []
        ]
    ];

    public function index(){
        $role = Role::where(['name' => config('constants.roles.doctor')])->firstOrFail();
        $data['doctors'] = User::where(['role_id' => $role->id,'facility_id' => auth()->user()->facility_id])->get();
        return view('admin.doctors.index',$data);
    }

    public function create(){
        $data['fields'] = $this->fields;
        return view('admin.doctors.create',$data);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|confirmed|unique:users,email'
        ]);
        $role = Role::where(['name' => config('constants.roles.doctor')])->firstOrFail();
        $validated['password'] = Hash::make('Welcome123');
        $validated['role_id'] = $role->id;
        $validated['facility_id'] = auth()->user()->facility_id;
        $user = User::create($validated);
        event(new Registered($user));
        session()->flash('success','Doctor Added!');
        return redirect(route('doctors.index'));
    }

    public function edit($id){
        $data['fields'] = $this->fields;
        $role = Role::where(['name' => config('constants.roles.doctor')])->firstOrFail();
        $data['doctor'] = User::where(['role_id' => $role->id,'facility_id' => auth()->user()->facility_id])->findOrFail($id);
        return view('admin.doctors.edit',$data);
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|confirmed|unique:users,email'
        ]);
        $role = Role::where(['name' => config('constants.roles.doctor')])->firstOrFail();
        $doctor = User::where(['role_id' => $role->id,'facility_id' => auth()->user()->facility_id])->findOrFail($id);
        $doctor->update($validated);
        session()->flash('success','Doctor Updated!');
        return redirect(route('doctors.index'));
    }

    public function destroy($id){
        $role = Role::where(['name' => config('constants.roles.doctor')])->firstOrFail();
        $doctor = User::where(['role_id' => $role->id,'facility_id' => auth()->user()->facility_id])->findOrFail($id);
        $doctor->delete();
        session()->flash('success','Doctor Deleted!');
        return redirect(route('doctors.index'));
    }
}
