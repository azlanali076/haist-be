<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    private array $fields = [
        [
            'name' => 'first_name',
            'id' => 'first_name',
            'placeholder' => 'Enter first name',
            'label' => 'First name',
            'type' => 'text',
            'options' => [],
            'required' => true
        ],
        [
            'name' => 'last_name',
            'id' => 'last_name',
            'placeholder' => 'Enter last name',
            'label' => 'Last name',
            'type' => 'text',
            'options' => [],
            'required' => true
        ],
        [
            'name' => 'email',
            'id' => 'email',
            'placeholder' => 'Enter email',
            'label' => 'Email',
            'type' => 'email',
            'options' => [],
            'required' => true
        ],
        [
            'name' => 'phone',
            'id' => 'phone',
            'placeholder' => 'Enter phone',
            'label' => 'Phone',
            'type' => 'tel',
            'options' => [],
            'required' => true
        ],
        [
            'name' => 'gender',
            'id' => 'gender',
            'placeholder' => 'Select Gender',
            'label' => 'Gender',
            'type' => 'select',
            'options' => [['label' => 'Male','value' => 'Male'],['label' => 'Female','value' => 'Female'],['label' => 'Others','value' => 'Others']],
            'required' => true
        ],
        [
            'name' => 'dob',
            'id' => 'dob',
            'placeholder' => 'Date of Birth',
            'label' => 'Date of Birth',
            'type' => 'date',
            'options' => [],
            'required' => false
        ],
    ];

    public function index(){
        $adminRole = Role::where(['name' => config('constants.roles.admin')])->firstOrFail();
        $data['admins'] = User::where(['role_id' => $adminRole->id])->get();
        return view('admin.admins.index',$data);
    }

    public function create(){
        $facilities = Facility::get();
        $data['fields'] = $this->fields;
        $data['fields'][] = [
            'name' => 'facility_id',
            'id' => 'facility_id',
            'placeholder' => 'Select Facility',
            'label' => 'Facility',
            'type' => 'select',
            'options' => $facilities->map(fn ($facility) => ['label' => $facility->name,'value' => $facility->id])->toArray(),
            'required' => false
        ];
        return view('admin.admins.create',$data);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
//            'password' => 'required',
            'phone' => 'nullable',
            'gender' => 'required|in:Male,Female,Others',
            'dob' => 'nullable|date',
            'facility_id' => 'nullable|exists:facilities,id'
        ]);
        $validated['password'] = Hash::make('Welcome123');
        $role = Role::where(['name' => config('constants.roles.admin')])->firstOrFail();
        $validated['role_id'] = $role->id;
        $user = User::create($validated);
        event(new Registered($user));
        session()->flash('success','Admin Added!');
        return redirect(route('admins.index'));
    }

    public function edit(User $admin){
        $facilities = Facility::get();
        $data['fields'] = $this->fields;
        $data['fields'][] = [
            'name' => 'facility_id',
            'id' => 'facility_id',
            'placeholder' => 'Select Facility',
            'label' => 'Facility',
            'type' => 'select',
            'options' => $facilities->map(fn ($facility) => ['label' => $facility->name,'value' => $facility->id])->toArray(),
            'required' => true
        ];
        $data['admin'] = $admin;
        return view('admin.admins.edit',$data);
    }

    public function update(Request $request, User $admin){
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
//            'password' => 'required',
            'phone' => 'nullable',
            'gender' => 'required|in:Male,Female,Others',
            'dob' => 'nullable|date',
            'facility_id' => 'required|exists:facilities,id'
        ]);
        $admin->update($validated);
        session()->flash('success','Admin Updated!');
        return redirect(route('admins.index'));
    }
}
