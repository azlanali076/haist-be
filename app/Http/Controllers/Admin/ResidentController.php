<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResidentRequest;
use App\Http\Requests\ResidentUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResidentController extends Controller
{
    public function index(){
        $role = Role::where(['name' => config('constants.roles.patient')])->firstOrFail();
        $data['residents'] = User::where(['role_id' => $role->id,'facility_id' => request()->user()->facility_id])->get();
        return view('admin.residents.index',$data);
    }

    public function create(){
        $role = Role::where(['name' => config('constants.roles.doctor')])->firstOrFail();
        $data['doctors'] = User::where(['role_id' => $role->id,'facility_id' => request()->user()->facility_id])->get();
        return view('admin.residents.create',$data);
    }

    public function store(ResidentRequest $request){
        $validated = $request->validated();
        unset($validated['avatar']);
        if($request->avatar and $request->hasFile('avatar')) {
            $fileName = time().'_'.$request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move(public_path('uploaded_data'),$fileName);
            $validated['avatar'] = $fileName;
        }
        $validated['role_id'] = (Role::where(['name' => config('constants.roles.patient')])->firstOrFail())->id;
        $validated['facility_id'] = $request->user()->facility_id;
        $validated['password'] = Hash::make('Welcome123');
        User::create($validated);
        $this->successMessage('Resident Added!');
        return redirect(route('residents.index'));
    }

    public function edit($id){
        $role = Role::where(['name' => config('constants.roles.doctor')])->firstOrFail();
        $data['doctors'] = User::where(['role_id' => $role->id,'facility_id' => request()->user()->facility_id])->get();
        $data['resident'] = User::byFacilityId()->isPatient()->findOrFail($id);
        return view('admin.residents.edit',$data);
    }

    public function update(ResidentUpdateRequest $request, $id){
        $validated = $request->validated();
        unset($validated['avatar']);
        if($request->avatar and $request->hasFile('avatar')) {
            $fileName = time().'_'.$request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move(public_path('uploaded_data'),$fileName);
            $validated['avatar'] = $fileName;
        }
        $validated['role_id'] = (Role::where(['name' => config('constants.roles.patient')])->firstOrFail())->id;
        User::byFacilityId()->isPatient()->findOrFail($id)->update($validated);
        $this->successMessage('Resident Updated!');
        return redirect(route('residents.index'));
    }

    public function destroy($id){
        User::byFacilityId()->isPatient()->findOrFail($id)->delete();
        $this->successMessage('Resident Deleted!');
        return redirect(route('residents.index'));
    }
}
