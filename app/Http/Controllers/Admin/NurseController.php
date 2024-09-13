<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class NurseController extends Controller
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
        $nurseRole = Role::whereIn('name',[config('constants.roles.nurse'),config('constants.roles.assistant_nurse')])->get()->pluck('id');
        $data['nurses'] = User::whereIn('role_id',$nurseRole)->whereIn('facility_id',request()->associated_facility_ids)->get();
        return view('admin.nurses.index',$data);
    }

    public function create(){
        $facilities = Facility::findMany(request()->associated_facility_ids);
        $nurseRoles = Role::where('name','like','%nurse%')->get();
        $data['fields'] = $this->fields;
        $data['fields'][] = [
            'type' => 'select',
            'label' => 'Facility',
            'placeholder' => 'Select Facility',
            'name' => 'facility_id',
            'id' => 'facility_id',
            'options' => $facilities->map(fn ($facility) => ['label' => $facility->name,'value' => $facility->id])->toArray(),
            'required' => true
        ];
        $data['fields'][] = [
            'name' => 'role_id',
            'id' => 'role_id',
            'placeholder' => 'Select Role',
            'type' => 'select',
            'options' => $nurseRoles->map(fn ($role) => ['label' => $role->name,'value' => $role->id])->toArray(),
            'required' => true,
            'label' => 'Role'
        ];
        return view('admin.nurses.create',$data);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'gender' => 'required|in:Male,Female,Others',
            'dob' => 'nullable',
            'facility_id' => 'required|exists:facilities,id',
            'role_id' => 'required|exists:roles,id'
        ]);
        $validated['password'] = Hash::make('Welcome123');
        $user = User::create($validated);
        event(new Registered($user));
        session()->flash('success','Nurse Added!');
        return redirect(route('nurses.index'));
    }

    public function edit(User $nurse){
        $facilities = Facility::findMany(request()->associated_facility_ids);
        $nurseRoles = Role::where('name','like','%nurse%')->get();
        $data['fields'] = $this->fields;
        $data['fields'][] = [
            'type' => 'select',
            'label' => 'Facility',
            'placeholder' => 'Select Facility',
            'name' => 'facility_id',
            'id' => 'facility_id',
            'options' => $facilities->map(fn ($facility) => ['label' => $facility->name,'value' => $facility->id])->toArray(),
            'required' => true
        ];
        $data['fields'][] = [
            'name' => 'role_id',
            'id' => 'role_id',
            'placeholder' => 'Select Role',
            'type' => 'select',
            'options' => $nurseRoles->map(fn ($role) => ['label' => $role->name,'value' => $role->id])->toArray(),
            'required' => true,
            'label' => 'Role'
        ];
        $data['nurse'] = $nurse;
        return view('admin.nurses.edit',$data);
    }

    public function update(Request $request, User $nurse){
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
            'gender' => 'required|in:Male,Female,Others',
            'dob' => 'nullable|date',
            'facility_id' => 'required|exists:facilities,id',
            'role_id' => 'required|exists:roles,id'
        ]);
        $nurse->update($validated);
        session()->flash('success','Nurse Updated!');
        return redirect(route('nurses.index'));
    }
}
