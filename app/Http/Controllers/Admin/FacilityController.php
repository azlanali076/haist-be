<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\FacilityAdmin;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class FacilityController extends Controller
{

    private array $fields = [
        [
            'type' => 'text',
            'name' => 'name',
            'id' => 'name',
            'placeholder' => 'Enter name',
            'label' => 'Name',
            'required' => true,
            'options' => []
        ],
        [
            'type' => 'email',
            'name' => 'email',
            'id' => 'email',
            'placeholder' => 'Enter email',
            'label' => 'Email',
            'required' => true,
            'options' => []
        ],
        [
            'type' => 'tel',
            'name' => 'phone',
            'id' => 'phone',
            'placeholder' => 'Enter phone',
            'label' => 'Phone',
            'required' => true,
            'options' => []
        ],
        [],
        [
            'type' => 'textarea',
            'name' => 'bio',
            'id' => 'bio',
            'placeholder' => 'Enter bio',
            'label' => 'Bio',
            'required' => false,
            'options' => []
        ]
    ];

    public function index(){
        $data['facilities'] = Facility::get();
        return view('admin.facilities.index',$data);
    }

    public function create(){
        $adminRole = Role::where(['name' => config('constants.roles.admin')])->firstOrFail();
        $data['fields'] = $this->fields;
        $data['fields'][3] = [
            'type' => 'select',
            'multiple' => true,
            'required' => true,
            'label' => 'Admins',
            'placeholder' => 'Select Admins',
            'name' => 'admin_ids[]',
            'id' => 'admin_ids',
            'options' => User::where(['role_id' => $adminRole->id])->get()->map(fn ($admin) => ['label' => $admin->full_name,'value' => $admin->id])->toArray()
        ];
        return view('admin.facilities.create',$data);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'bio' => 'nullable',
            'admin_ids' => 'required|array|min:1',
            'admin_ids.*' => 'exists:users,id'
        ]);
        unset($validated['admin_ids']);
        $facility = Facility::create($validated);
        foreach ($request->admin_ids as $admin_id) {
            FacilityAdmin::create([
                'facility_id' => $facility->id,
                'admin_id' => $admin_id
            ]);
        }
        session()->flash('success','Facility Added!');
        return redirect(route('facilities.index'));
    }

    public function edit(Facility $facility){
        $adminRole = Role::where(['name' => config('constants.roles.admin')])->firstOrFail();
        $data['facility'] = $facility;
        $data['fields'] = $this->fields;
        $data['fields'][3] = [
            'type' => 'select',
            'multiple' => true,
            'required' => true,
            'label' => 'Admins',
            'placeholder' => 'Select Admins',
            'name' => 'admin_ids[]',
            'id' => 'admin_ids',
            'options' => User::where(['role_id' => $adminRole->id])->get()->map(fn ($admin) => ['label' => $admin->full_name,'value' => $admin->id])->toArray()
        ];
        return view('admin.facilities.edit',$data);
    }

    public function update(Request $request, Facility $facility){
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'bio' => 'nullable',
            'admin_ids' => 'required|array|min:1',
            'admin_ids.*' => 'exists:users,id'
        ]);
        unset($validated['admin_ids']);
        $facility->update($validated);
        foreach ($request->admin_ids as $admin_id) {
            FacilityAdmin::firstOrCreate(['facility_id' => $facility->id,'admin_id' => $admin_id]);
        }
        session()->flash('success','Facility Updated!');
        return redirect(route('facilities.index'));
    }

    public function destroy(Facility $facility){
        try{
            $facility->delete();
            session()->flash('success','Facility Deleted!');
            return redirect(route('facilities.index'));
        }
        catch (\Exception $e){
            session()->flash('error','Error in deleting Facility');
            return redirect(route('facilities.index'));
        }
    }
}
