<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PatientSymptom;
use App\Models\Role;
use App\Models\User;
use App\Notifications\SymptomReported;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PatientSymptomController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'symptom_ids' => 'required|array|min:1',
            'symptom_ids.*' => 'exists:symptoms,id'
        ]);
        $role = Role::where(['name' => config('constants.roles.patient')])->firstOrFail();
        $patient = User::where(['role_id' => $role->id,'facility_id' => $request->user()->facility_id])->findOrFail($request->patient_id);

        $nurseRole = Role::where(['name' => config('constants.roles.nurse')])->firstOrFail();
        $managerRole = Role::where(['name' => config('constants.roles.manager')])->firstOrFail();

        $notifyToUsers = User::where(['facility_id' => $request->user()->facility_id])->whereIn('role_id',[$nurseRole->id,$managerRole->id])->get();

        foreach ($request->symptom_ids as $symptom_id) {
            $patientSymptom = PatientSymptom::create([
                'facility_id' => $request->user()->facility_id,
                'symptom_id' => $symptom_id,
                'patient_id' => $patient->id,
                'assistant_nurse_id' => $request->user()->id
            ]);
            /** @var PatientSymptom $patientSymptom */
            $patientSymptom = PatientSymptom::with(['patient','assistantNurse','symptom'])->findOrFail($patientSymptom->id);
            Notification::sendNow($notifyToUsers, new SymptomReported($patientSymptom));
        }
        return $this->success('Symptoms Reported!');
    }
}
