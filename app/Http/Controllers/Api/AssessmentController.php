<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\AssessmentEmail;
use App\Models\Assessment;
use App\Models\AssessmentPossibleDisease;
use App\Models\AssessmentSymptom;
use App\Models\Diagnose;
use App\Models\DiagnoseCase;
use App\Models\DiagnoseCondition;
use App\Models\DiagnoseCriteria;
use App\Models\Facility;
use App\Models\PatientSymptom;
use App\Models\Role;
use App\Models\Symptom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AssessmentController extends Controller
{
    public function index(){
        $assessments = Assessment::where(['facility_id' => request()->facility_id])->with(['possibleDiseases','patient'])->get();
        return $this->success('Got Assessments',$assessments);
    }

    public function store(Request $request){
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'symptom_ids' => 'required|array',
            'symptom_ids.*' => 'exists:symptoms,id',
            'heart_rate' => 'required',
            'temperature' => 'required',
            'o2_saturation' => 'required',
            'base_o2_saturation' => 'required',
            'respiratory_rate' => 'required',
            'blood_pressure' => 'required',
            'blood_pressure_down_value' => 'required'
        ]);
        $assessmentData = $request->only(['patient_id','facility_id','heart_rate','temperature','o2_saturation','base_o2_saturation','respiratory_rate','blood_pressure','blood_pressure_down_value']);
        $assessmentData['nurse_id'] = $request->user()->id;
        $assessment = Assessment::create($assessmentData);
        foreach ($request->symptom_ids as $symptom_id) {
            AssessmentSymptom::create([
                'assessment_id' => $assessment->id,
                'symptom_id' => $symptom_id
            ]);
        }
        /** @var Assessment $assessment */
        $assessment = Assessment::with(['symptoms'])->findOrFail($assessment->id);
        $matchedDiseases = [];
        $allDiseases = Diagnose::with(['tests'])->get();
        foreach ($allDiseases as $disease) {
            if($this->checkIfDiseaseMatches($disease,$assessment)){
                $matchedDiseases[] = $disease;
            }
        }

        foreach ($matchedDiseases as $matchedDisease) {
            AssessmentPossibleDisease::create([
                'assessment_id' => $assessment->id,
                'disease_id' => $matchedDisease->id
            ]);
        }
        PatientSymptom::where(['patient_id' => $request->patient_id])->update(['assessment_id' => $assessment->id]);
        $data = [
            'assessment' => $assessment,
            'possible_diseases' => $matchedDiseases
        ];
        return $this->success('Assessment Added!',$data);
    }

    /**
     * @param Diagnose $diagnose
     * @param Assessment $assessment
     * @return bool
     */
    private function checkIfDiseaseMatches(Diagnose $diagnose, Assessment $assessment){
        $conditionsMatched = array_fill(0,count($diagnose->diagnoseConditions),false);
        $conditionsType = [];
        foreach ($diagnose->diagnoseConditions as $k=>$condition) {
            $conditionsType[] = $condition->type;
            $conditionsMatched[$k] = $this->checkDiseaseCondition($condition,$assessment);
        }

//        Log::channel('discord')->debug('Conditions Type',$conditionsType);
//        sleep(1);
//        Log::channel('discord')->debug('Conditions Matched',$conditionsMatched);

        $diseaseMatched = false;
        if(count($diagnose->diagnoseConditions) > 1) {
            foreach ($conditionsType as $k=>$conditionType) {
                if($conditionType === 'and'){
                    $diseaseMatched = ($conditionsMatched[$k] and $conditionsMatched[$k-1]);
                }
                else if($conditionType === 'or'){
                    $diseaseMatched = ($conditionsMatched[$k] or $conditionsMatched[$k-1]);
                    if($diseaseMatched) {
                        break;
                    }
                }
            }
        }
        else{
            $diseaseMatched = $conditionsMatched[0];
        }

        return $diseaseMatched;
    }

    /**
     * @param DiagnoseCondition $condition
     * @param Assessment $assessment
     * @return bool
     */
    private function checkDiseaseCondition (DiagnoseCondition $condition, Assessment $assessment) {
        $matchedCases = 0;
        foreach ($condition->cases as $case) {
            if($case->case_type === Symptom::class) {
                if(!$this->checkSymptom($case->case_id,$assessment->id)) {
                    if($case->must_include) {
                        break;
                    }
                }
                else{
                    $matchedCases++;
                }
            }
            else if($case->case_type === DiagnoseCriteria::class and !empty($case->case)){
                if(!$this->checkCriteriaCase($case->case,$assessment)) {
                    if($case->must_include) {
                        break;
                    }
                }
                else{
                    $matchedCases++;
                }
            }
        }
        return $matchedCases >= $condition->compulsory_cases;
    }

    /**
     * @param DiagnoseCriteria $case
     * @param Assessment $assessment
     * @return bool
     */
    private function checkCriteriaCase(DiagnoseCriteria $case, Assessment $assessment){
        $vitalKey = $case->criteria_key;
        $vitalValue = $case->criteria_value;
        $criteriaComparisonOperator = $case->criteria_comparison_operator;
        if($vitalKey != config('constants.criteria.blood_pressure.key')){
            if(!version_compare($assessment->$vitalKey,$vitalValue,$criteriaComparisonOperator)) {
                return false;
            }
        }
        else{
            if(!version_compare($assessment->$vitalKey,$vitalValue,$criteriaComparisonOperator) or !version_compare($assessment->blood_pressure_down_value,$case->blood_pressure_down_value,$criteriaComparisonOperator)) {
                return false;
            }
        }
        return true;
    }

    private function checkSymptom($symptomId, $assessmentId){
        $symptomFound = AssessmentSymptom::where(['assessment_id' => $assessmentId,'symptom_id' => $symptomId])->exists();
        if(!$symptomFound) {
            return false;
        }
        return true;
    }

//    public function store(Request $request){
//        $request->validate([
//            'patient_id' => 'required|exists:users,id',
//            'symptom_ids' => 'required|array',
//            'symptom_ids.*' => 'exists:symptoms,id',
//            'heart_rate' => 'required',
//            'temperature' => 'required',
//            'o2_saturation' => 'required',
//            'base_o2_saturation' => 'required',
//            'respiratory_rate' => 'required',
//            'blood_pressure' => 'required',
//        ]);
//        $assessment = Assessment::create($request->only(['patient_id','facility_id','heart_rate','temperature','o2_saturation','base_o2_saturation','respiratory_rate','blood_pressure']));
//        foreach ($request->symptom_ids as $symptom_id) {
//            AssessmentSymptom::create([
//                'assessment_id' => $assessment->id,
//                'symptom_id' => $symptom_id
//            ]);
//        }
//        $matchedDiseases = [];
//        $allDiseases = Diagnose::with(['tests'])->get();
//        foreach ($allDiseases as $disease) {
//
//            if ($disease->check_current_saturation) {
//                // if condition passes then move to after if else check fall back criteria
//                if (($assessment->o2_saturation - $assessment->base_o2_saturation) < $disease->saturation_difference_value) {
//                    // Check FallBack Criteria
//                    if ($disease->fallbackCriteria) {
//                        $vitalKey = $disease->fallbackCriteria->criteria_key;
//                        if(version_compare($request->$vitalKey,$disease->fallbackCriteria->criteria_value,$disease->fallbackCriteria->criteria_comparison_operator)) {
//                            $matchedDiseases[] = $disease;
//                            AssessmentPossibleDisease::create([
//                                'assessment_id' => $assessment->id,
//                                'disease_id' => $disease->id
//                            ]);
//                        }
//                    }
//                    else{
//                        // if fallback criteria also fails then continue on the next disease
//                        continue;
//                    }
//                }
//            }
//
//            $compulsorySymptoms = $disease->compulsory_symptoms;
//            $matchedSymptoms = 0;
//            $matchedSymptomIds = [];
//            foreach ($request->symptom_ids as $symptom_id) {
//                if (in_array($symptom_id,$disease->symptom_ids)) {
//                    $matchedSymptoms++;
//                    $matchedSymptomIds[] = $symptom_id;
//                }
//            }
//            if($compulsorySymptoms <= $matchedSymptoms) {
//
//                $allMustIncludeSymptomsMatched = true;
//                if(count($disease->must_include_symptom_ids) > 0) {
//                    foreach ($disease->must_include_symptom_ids as $symptom_id) {
//                        if(!in_array($symptom_id,$matchedSymptomIds)) {
//                            $allMustIncludeSymptomsMatched = false;
//                        }
//                    }
//                }
//
//                if($allMustIncludeSymptomsMatched) {
//                    if (count($disease->must_include_criteria_ids) > 0) {
//                        $mustIncludeCriteriasCount = count($disease->must_include_criteria_ids);
//                        $matchedIncludeCriteriasCount = 0;
//                        $mustIncludeCriterias = DiagnoseCriteria::findMany($disease->must_include_criteria_ids);
//                        foreach ($mustIncludeCriterias as $mustIncludeCriteria) {
//                            $vitalKey = $mustIncludeCriteria->criteria_key;
//                            if(version_compare($request->$vitalKey,$mustIncludeCriteria->criteria_value,$mustIncludeCriteria->criteria_comparison_operator)) {
//                                $matchedIncludeCriteriasCount++;
//                            }
//                        }
//                        if ($mustIncludeCriteriasCount == $matchedIncludeCriteriasCount) {
//                            $matchedDiseases[] = $disease;
//                            AssessmentPossibleDisease::create([
//                                'assessment_id' => $assessment->id,
//                                'disease_id' => $disease->id
//                            ]);
//                        }
//                    }
//                }
//                else if ($disease->fallbackCriteria){
//                    $vitalKey = $disease->fallbackCriteria->criteria_key;
//                    if(version_compare($request->$vitalKey,$disease->fallbackCriteria->criteria_value,$disease->fallbackCriteria->criteria_comparison_operator)) {
//                        $matchedDiseases[] = $disease;
//                        AssessmentPossibleDisease::create([
//                            'assessment_id' => $assessment->id,
//                            'disease_id' => $disease->id
//                        ]);
//                    }
//                }
//            }
//            else if ($disease->fallbackCriteria) {
//                $vitalKey = $disease->fallbackCriteria->criteria_key;
//                if(version_compare($request->$vitalKey,$disease->fallbackCriteria->criteria_value,$disease->fallbackCriteria->criteria_comparison_operator)) {
//                    $matchedDiseases[] = $disease;
//                    AssessmentPossibleDisease::create([
//                        'assessment_id' => $assessment->id,
//                        'disease_id' => $disease->id
//                    ]);
//                }
//            }
//        }
//        $data['assessment'] = $assessment;
//        $data['possible_diseases'] = $matchedDiseases;
//        return $this->success('Assessment Added!',$data);
//    }

    public function show($id){
        $assessment = Assessment::with(['symptoms','patient','possibleDiseases'])->findOrFail($id);
        return $this->success('Got Assessment',$assessment);
    }

    public function update(Request $request,$id){
        $validated = $request->validate([
            'status' => 'required|in:Pending,Completed',
            'diagnose_id' => 'nullable|exists:diagnoses,id',
            'heart_rate' => 'nullable',
            'temperature' => 'nullable',
            'o2_saturation' => 'nullable',
            'base_o2_saturation' => 'nullable',
            'respiratory_rate' => 'nullable',
            'blood_pressure' => 'nullable',
            'blood_pressure_down_value' => 'nullable'
        ]);
        Assessment::findOrFail($id)->update($validated);
        $assessment = Assessment::with(['symptoms','patient','possibleDiseases','diagnose'])->findOrFail($id);
        return $this->success('Assessment Updated!',$assessment);
    }

    public function email(Request $request,$id){
        $validated = $request->validate([
            'send_to' => 'required'
        ]);
        $facility = Facility::findOrFail($request->facility_id);
        $assessment = Assessment::findOrFail($id);
        $managerRole = Role::where(['name' => config('constants.roles.manager')])->first();
        $drRole = Role::where(['name' => config('constants.roles.doctor')])->first();
        $manager = User::where(['role_id' => $managerRole->id])->first();
        $doctor = User::where(['role_id' => $drRole->id,'id' => $assessment->patient->doctor_id])->first();
        if($validated['send_to'] === 'manager') {
            if (!$manager) {
                return $this->error('Manager Not Found!');
            }
            Mail::to($manager->email)->send(new AssessmentEmail($facility,$assessment));
        }
        else {
            if(!$doctor) {
                return $this->error('Doctor Not Assigned');
            }
            Mail::to($doctor->email)->send(new AssessmentEmail($facility,$assessment));
        }
        return $this->success('Email Sent!');
    }

    public function destroy($id){
        Assessment::findOrFail($id)->delete();
        return $this->success('Assessment Deleted!');
    }
}
