<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentPossibleDisease;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function index(){
        $assessmentsQuery = Assessment::where(['facility_id' => request()->user()->facility_id]);
        $data['assessments'] = $assessmentsQuery->byStatus(request()->status)->paginate(10);
        return view('admin.assessments.index',$data);
    }

    public function possibleDiseases($id){
        $data['possible_diseases'] = AssessmentPossibleDisease::where(['assessment_id' => $id])->get();
        return view('admin.assessments.possible-diseases-modal',$data);
    }
}
