<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
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
        $managerRole = Role::where(['name' => config('constants.roles.manager')])->firstOrFail();
        $data['managers'] = User::where(['role_id' => $managerRole->id])->whereIn('facility_id',request()->associated_facility_ids)->get();
        return view('admin.managers.index',$data);
    }

    public function create(){
        $facilities = Facility::findMany(request()->associated_facility_ids);
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
        return view('admin.managers.create',$data);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'gender' => 'required|in:Male,Female,Others',
            'dob' => 'nullable',
            'facility_id' => 'required|exists:facilities,id'
        ]);
        $validated['password'] = Hash::make('Welcome123');
        $role = Role::where(['name' => config('constants.roles.manager')])->firstOrFail();
        $validated['role_id'] = $role->id;
        $user = User::create($validated);
//        event(new Registered($user));
        session()->flash('success','Manager Added!');
        return redirect(route('managers.index'));
    }

    public function edit(User $manager){
        $myId = auth()->user()->id;
        $facilities = Facility::findMany(request()->associated_facility_ids);
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
        $data['manager'] = $manager;
        return view('admin.managers.edit',$data);
    }

    public function update(Request $request, User $manager){
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
            'gender' => 'required|in:Male,Female,Others',
            'dob' => 'nullable|date',
            'facility_id' => 'required|exists:facilities,id'
        ]);
        $manager->update($validated);
        session()->flash('success','Manager Updated!');
        return redirect(route('managers.index'));
    }
}
