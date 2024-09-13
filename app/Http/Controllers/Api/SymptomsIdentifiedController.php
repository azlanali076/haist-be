<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssessmentSymptom;
use App\Models\PatientSymptom;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SymptomsIdentifiedController extends Controller
{
    public function index(){
        $facilityId = request()->user()->facility_id;
        $symptomsIdentified = PatientSymptom::where(['facility_id' => $facilityId])
            ->where('created_at','>=',Carbon::now()->subDays(2))
            ->with(['symptom','assistantNurse','patient'])->get();
//        $symptomsIdentified = AssessmentSymptom::whereHas('assessment',function($q) use ($facilityId) {
//            $q->where('facility_id',$facilityId);
//        })->where('created_at','>=',Carbon::now()->subDays(2))->with(['assessment','assessment.patient','user','symptom'])->get();
        return $this->success('Got Identified Symptoms',$symptomsIdentified);
    }
}
