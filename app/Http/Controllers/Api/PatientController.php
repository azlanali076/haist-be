<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PatientSymptom;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index(){
        $role = Role::where(['name' => config('constants.roles.patient')])->firstOrFail();
        $patients = User::with(['doctor'])->where(['facility_id' => request()->user()->facility_id,'role_id' => $role->id])->get();
        return $this->success('Got Patients',$patients);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Others',
            'room_number' => 'required',
            'doctor_id' => 'required|exists:users,id',
            'avatar' => 'nullable|file|image'
        ]);
        unset($validated['avatar']);
        $role = Role::where(['name' => config('constants.roles.patient')])->firstOrFail();
        $validated['facility_id'] = $request->user()->facility_id;
        $validated['password'] = Hash::make('Welcome123');
        $validated['role_id'] = $role->id;
        if($request->avatar and $request->hasFile('avatar')) {
            $fileName = time().'_'.$request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move(public_path('uploaded_data'),$fileName);
            $validated['avatar'] = $fileName;
        }
        $patient = User::create($validated);
        return $this->success('Patient Added!',$patient);
    }

    public function update(Request $request, User $patient){
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Others',
            'avatar' => 'nullable|file|image',
            'room_number' => 'nullable',
            'doctor_id' => 'nullable|exists:users,id'
        ]);
        unset($validated['avatar']);
        if($request->avatar and $request->hasFile('avatar')) {
            $fileName = time().'_'.$request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move(public_path('uploaded_data'),$fileName);
            $validated['avatar'] = $fileName;
        }
        $patient->update($validated);
        $patient = User::findOrFail($patient->id);
        return $this->success('Patient Updated!',$patient);
    }

    public function destroy(User $patient){
        $patient->delete();
        return $this->success('Patient Deleted!');
    }

    public function confirm(Request $request){
        $request->validate([
            'room_number' => 'required',
            'patient_id' => 'required|exists:users,id'
        ]);
        $role = Role::where(['name' => config('constants.roles.patient')])->firstOrFail();
        $patient = User::where(['role_id' => $role->id,'facility_id' => $request->user()->facility_id])->findOrFail($request->patient_id);
        if($patient->room_number != $request->room_number) {
            return $this->error('Incorrect Information!');
        }
        $reportedSymptoms = DB::table('patient_symptoms')->select('symptoms.*')
            ->join('symptoms','symptoms.id','=','patient_symptoms.symptom_id')
            ->where('patient_symptoms.patient_id','=',$request->patient_id)
            ->whereNull('patient_symptoms.assessment_id')->get();
        return $this->success('Reported Symptoms are',['reported_symptoms' => $reportedSymptoms]);
    }
}
