<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentSymptom;
use App\Models\AssessmentTest;
use App\Models\Diagnose;
use App\Models\Facility;
use App\Models\Group;
use App\Models\Symptom;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        $data = [];
        $data['symptoms_collection'] = Symptom::orderBy('name', 'asc')->get();
        $data['diseases_collection'] = Diagnose::orderBy('name', 'asc')->get();
        $data['symptoms'] = [];
        $data['diagnoses'] = [];
        $data['symptom_ids'] = '';
        $data['disease_ids'] = '';
        if (isset(request()->symptoms) && !empty(request()->symptoms)) {
            $data['symptom_ids'] = request()->symptoms;
            $assesmentIds = Assessment::where('facility_id', request()->user()->facility_id)->pluck('id')->toArray();

            $query = AssessmentSymptom::when(isset(request()->date_range), function ($query) {
                if (request()->date_range == "today") {
                    $query->where('created_at', 'Like', '%' . now()->format('Y-m-d') . '%');
                }
                if (request()->date_range == "yesterday") {
                    $query->where('created_at', 'Like', '%' . now()->subDay(1)->format('Y-m-d') . '%');
                }
                if (request()->date_range == "week") {
                    $query->where('created_at', '>=', now()->subDay(7)->format('Y-m-d'));
                }
                if (request()->date_range == "month") {
                    $query->where('created_at', '>=', now()->subDay(30)->format('Y-m-d'));
                }
            });

            $symptoms = $query->whereIn('assessment_id', $assesmentIds)
                ->select('symptom_id', DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
                ->groupBy('symptom_id', 'date')
                ->get()
                ->toArray();

            foreach ($symptoms as $item) {
                $symptomId = $item['symptom_id'];
                $date = $item['date'];
                $count = $item['count'];

                if (!isset($data['symptoms'][$symptomId])) {
                    $data['symptoms'][$symptomId] = [
                        'symptom_id' => $symptomId,
                        'symptom_name' => getSymptomName($symptomId),
                        'dates' => [],
                        'counts' => [],
                    ];
                }

                $data['symptoms'][$symptomId]['dates'][] = $date;
                $data['symptoms'][$symptomId]['counts'][] = $count;
            }
            if (request()->symptoms != "all") {
                $specificSymptomId = request()->symptoms;
                $specificSymptomData = $data['symptoms'][$specificSymptomId] ?? null;

                $data['symptoms'] = [];
                if ($specificSymptomData) {
                    $data['symptoms'][] = $specificSymptomData;
                }
            }
        }
        if (isset(request()->diseases) && !empty(request()->diseases)){
            $data['disease_ids'] = request()->diseases;
            $diagnoses = Assessment::when(isset(request()->diseases), function($query){
                if (request()->diseases != "all"){
                    $query->where('diagnose_id', request()->diseases);
                }
            })->where(['facility_id' => request()->user()->facility_id, 'status' => 'Completed'])
                ->select('id', 'diagnose_id', DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
                ->groupBy('date')
                ->get()
                ->toArray();
            foreach ($diagnoses as $diagnosis) {
                $diagnoseId = $diagnosis['diagnose_id'];
                $diagnoseDate = $diagnosis['date'];
                $diagnoseCount = $diagnosis['count'];

                if (!isset($data['diagnoses'][$diagnoseId])) {
                    $data['diagnoses'][$diagnoseId] = [
                        'diagnose_id' => $diagnoseId,
                        'diagnose_name' => getDiagnoseName($diagnoseId),
                        'dates' => [],
                        'counts' => [],
                    ];
                }

                $data['diagnoses'][$diagnoseId]['dates'][] = $diagnoseDate;
                $data['diagnoses'][$diagnoseId]['counts'][] = $diagnoseCount;
            }
            if (request()->diseases == "all") {
                $specificDiagnoseId = request()->diseases;
                $specificDiagnoseData = $data['diagnoses'][$specificDiagnoseId] ?? null;

                $data['symptoms'] = [];
                if ($specificDiagnoseData) {
                    $data['diagnoses'][] = $specificDiagnoseData;
                }
            }
        }
        if(request()->user()->role->name == config('constants.roles.haist_admin')){
            return view('admin.haist-admin-home');
        }
        else if(request()->user()->role->name === config('constants.roles.admin')){
            $data['facilities'] = $this->facilityRanking(request()->user()->associated_facility_ids,request()->ranking_by ?? 'symptoms',request()->date_range ?? 'month');
            $fromDate = match (request()->date_range) {
                'today' => now(),
                'week' => now()->subWeeks(),
                'yesterday' => now()->subDays(),
                default => now()->subMonths()
            };
            $facilityIds = request()->user()->associated_facility_ids;
            $data['total_symptoms'] = AssessmentSymptom::whereHas('assessment',function($q) use ($facilityIds) {
                $q->whereIn('facility_id',$facilityIds);
            })
                ->whereDate('created_at','>=',$fromDate->format('Y-m-d'))
                ->whereDate('created_at','<=',now()->format('Y-m-d'))->count();
            $data['total_assessments'] = Assessment::whereIn('facility_id',$facilityIds)->whereDate('created_at','>=',$fromDate->format('Y-m-d'))
                ->whereDate('created_at','<=',now()->format('Y-m-d'))->count();
            $data['total_diseases'] = Assessment::whereIn('facility_id',$facilityIds)->where('status','=','Completed')
                ->whereDate('created_at','>=',$fromDate->format('Y-m-d'))
                ->whereDate('created_at','<=',now()->format('Y-m-d'))->count();
            return view('admin.home',$data);
        }
        else if(request()->user()->role->name === config('constants.roles.manager')){
            $assessmentsQuery = Assessment::where('facility_id', request()->user()->facility_id);
            $testsQuery = AssessmentTest::where(['facility_id' => request()->user()->facility_id]);
            switch (request()->date_range) {
                case 'week':
                    $assessmentsQuery->whereDate('created_at','>=',now()->subDays(7)->format('Y-m-d'));
                    $testsQuery->whereDate('created_at','>=',now()->subDays(7)->format('Y-m-d'));
                    break;
                case 'today':
                    $assessmentsQuery->whereDate('created_at','>=',now()->format('Y-m-d'));
                    $testsQuery->whereDate('created_at','>=',now()->format('Y-m-d'));
                    break;
                case 'yesterday':
                    $assessmentsQuery->whereDate('created_at','>=',now()->subDays()->format('Y-m-d'));
                    $testsQuery->whereDate('created_at','>=',now()->subDays()->format('Y-m-d'));
                    break;
                default:
                    $assessmentsQuery->whereDate('created_at','>=',now()->subMonths()->format('Y-m-d'));
                    $testsQuery->whereDate('created_at','>=',now()->subMonths()->format('Y-m-d'));
                    break;
            }
            $outbreaksQuery = clone $assessmentsQuery;
            $pendingDiagnosisQuery = clone $assessmentsQuery;
            $newAssesmentIds = $assessmentsQuery->get()->pluck('id')->values()->toArray();
            $symptomsQuery = AssessmentSymptom::whereIn('assessment_id', $newAssesmentIds)
                ->select('symptom_id', 'assessment_id', 'created_at')
                ->latest();
            $query = $symptomsQuery->limit(10)->get()->toArray();
            $data['stats']['assessments'] = $assessmentsQuery->count();
            $data['stats']['symptoms'] = $symptomsQuery->count();
            $data['stats']['outbreaks'] = $outbreaksQuery->where('status','Completed')->count();
            $data['stats']['pending_diagnosis'] = $pendingDiagnosisQuery->where('status','!=','Completed')->count();
            $data['stats']['pending_results'] = $testsQuery->where('status','=',AssessmentTest::STATUS_PENDING)->count();
            $data['symptoms_two'] = $query;
            $data['assessments_two'] = $assessmentsQuery->latest()->limit(10)->get()->toArray();
            $data['confirmed_diagnosis'] = $assessmentsQuery->where('status','Completed')->latest()->limit(10)->get()->toArray();
            return view('admin.clinical-manager1', $data);
        }

        return view('admin.clinical-manager2',$data);
    }

    public function compareFacilities(){
        $data['comparison_data'] = false;
        $data['facilities'] = Facility::whereIn('id',request()->user()->associated_facility_ids)->get();
        $data['symptoms'] = Symptom::get();
        $data['diseases'] = Diagnose::get();
        $data['groups'] = Group::where(['admin_id' => request()->user()->id])->get();

        if(request()->facility_group_id_1 and request()->facility_group_id_2){
            $data['comparison_data'] = true;
            $facilityGroupId1 = explode('_',request()->facility_group_id_1);
            $facilityGroupId2 = explode('_',request()->facility_group_id_2);
            if($facilityGroupId1[0] === 'facility') {
                $data['facility_1']['type'] = 'facility';
                $data['facility_1']['data'] = Facility::findOrFail($facilityGroupId1[1]);
            }
            else{
                $data['facility_1']['type'] = 'group';
                $data['facility_1']['data'] = Group::findOrFail($facilityGroupId1[1]);
            }
            if($facilityGroupId2[0] === 'facility') {
                $data['facility_2']['type'] = 'facility';
                $data['facility_2']['data'] = Facility::findOrFail($facilityGroupId2[1]);
            }
            else{
                $data['facility_2']['type'] = 'group';
                $data['facility_2']['data'] = Group::findOrFail($facilityGroupId2[1]);
            }
        }

        return view('admin.compare-facilities',$data);
    }


    /**
     * @param array $facilityIds
     * @param string|null $rankingBy
     * @param string|null $dateRange
     * @return Collection
     */
    private function facilityRanking(array $facilityIds,?string $rankingBy = 'symptoms',?string $dateRange = 'month'){
        $facilitiesQuery = Facility::whereIn('facilities.id',$facilityIds);
        $dateTo = now();
        $dateFrom = match ($dateRange) {
            'month' => now()->subMonths(),
            'week' => now()->subWeeks(),
            'yesterday' => now()->subDays(),
            default => now(),
        };
        switch ($rankingBy) {
            case 'symptoms':
                $facilitiesQuery->leftJoin('assessments','assessments.facility_id','=','facilities.id')
                    ->leftJoin('assessment_symptoms','assessment_symptoms.assessment_id','=','assessments.id')
                    ->selectRaw('facilities.id,facilities.name,COUNT(assessment_symptoms.id) as total_symptoms')
                    ->whereDate('assessment_symptoms.created_at','>=',$dateFrom->format('Y-m-d'))
                    ->whereDate('assessment_symptoms.created_at','<=',$dateTo->format('Y-m-d'))
                    ->orderBy('total_symptoms')
                    ->groupBy(['facilities.id','facilities.name']);
                break;
            case 'assessments':
                $facilitiesQuery->leftJoin('assessments','assessments.facility_id','=','facilities.id')
                    ->selectRaw('facilities.id,facilities.name,COUNT(assessments.id) as total_assessments')
                    ->whereDate('assessments.created_at','>=',$dateFrom->format('Y-m-d'))
                    ->whereDate('assessments.created_at','<=',$dateTo->format('Y-m-d'))
                    ->orderBy('total_assessments')
                    ->groupBy(['facilities.id','facilities.name']);
                break;
            case 'diagnoses':
                $facilitiesQuery->leftJoin('assessments','assessments.facility_id','=','facilities.id')
                    ->selectRaw('facilities.id,facilities.name,COUNT(assessments.id) as total_diagnoses')
                    ->whereDate('assessments.created_at','>=',$dateFrom->format('Y-m-d'))
                    ->whereDate('assessments.created_at','<=',$dateTo->format('Y-m-d'))
                    ->where('assessments.status','=',"Completed")
                    ->orderBy('total_diagnoses')
                    ->groupBy(['facilities.id','facilities.name']);
                break;
            default:
                $facilitiesQuery->leftJoin('assessments','assessments.facility_id','=','facilities.id')
                    ->selectRaw('facilities.id,facilities.name')
                    ->whereDate('assessments.created_at','>=',$dateFrom->format('Y-m-d'))
                    ->whereDate('assessments.created_at','<=',$dateTo->format('Y-m-d'))
                    ->groupBy(['facilities.id','facilities.name']);
                break;
        }
        if($rankingBy === 'response_time'){
            return $facilitiesQuery->get()->sortBy('avg_response_time')->values()->all();
        }
        else{
            return $facilitiesQuery->get();
        }
    }
}
