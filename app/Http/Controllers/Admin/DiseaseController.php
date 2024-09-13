<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diagnose;
use App\Models\DiagnoseCase;
use App\Models\DiagnoseCondition;
use App\Models\DiagnoseCriteria;
use App\Models\DiagnoseTest;
use App\Models\DiseaseTest;
use App\Models\Symptom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiseaseController extends Controller
{
    public function index(){
        $data['diseases'] = Diagnose::get();
        return view('admin.diseases.index',$data);
    }

    public function create(){
        $data['symptoms'] = Symptom::get();
        $data['criterias'] = DiagnoseCriteria::get();
        $data['tests'] = DiseaseTest::get();
        return view('admin.diseases.create',$data);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'conditions' => 'required|array|min:1',
            'conditions.*.type' => 'in:main,or,and',
            'conditions.*.compulsory_symptoms' => 'required|numeric|min:1',
            'conditions.*.check_o2_saturation' => 'required|in:Yes,No',
            'conditions.*.o2_saturation_difference_value' => 'nullable',
            'conditions.*.cases' => 'required|array|min:1',
            'conditions.*.cases.*.times' => 'numeric|min:1',
            'conditions.*.cases.*.case' => 'present',
            'test_ids' => 'required|array|min:1'
        ]);
        try{
            DB::beginTransaction();
            $diagnose = Diagnose::create([
                'name' => $request->name
            ]);
            foreach ($request->conditions as $condition) {
                $diagnoseCondition = DiagnoseCondition::create([
                    'diagnose_id' => $diagnose->id,
                    'compulsory_cases' => $condition['compulsory_symptoms'],
                    'type' => $condition['type'],
                    'check_o2_saturation' => $condition['check_o2_saturation'] == 'Yes',
                    'o2_saturation_difference_value' => $condition['o2_saturation_difference_value'] ?? 0.0
                ]);
                if(isset($condition['cases']) and count($condition['cases']) > 0) {
                    foreach ($condition['cases'] as $case) {
                        $explodedCase = explode('_',$case['case']);
                        $caseType = null;
                        if($explodedCase[0] == 'symptom') {
                            $caseType = Symptom::class;
                        }
                        else{
                            $caseType = DiagnoseCriteria::class;
                        }
                        DiagnoseCase::create([
                            'diagnose_id' => $diagnose->id,
                            'diagnose_condition_id' => $diagnoseCondition->id,
                            'case_type' => $caseType,
                            'case_id' => $explodedCase[1],
                            'must_include' => (isset($case['must_include']) and isset($case['must_include'][0]) and $case['must_include'][0]) ? 1 : 0
                        ]);
                    }
                }
            }
            foreach ($request->test_ids as $test_id) {
                DiagnoseTest::create([
                    'diagnose_id' => $diagnose->id,
                    'test_id' => $test_id
                ]);
            }
            DB::commit();
            session()->flash('success','Disease Added!');
            return redirect(route('diseases.index'));
        }
        catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error','An error in adding Disease');
            return redirect()->back()->withInput($request->all());
        }
    }

    public function show($id){
        $data['diagnose'] = Diagnose::findOrFail($id);
        return view('admin.diseases.show',$data);
    }

    public function edit($id){
        $data['symptoms'] = Symptom::get();
        $data['criterias'] = DiagnoseCriteria::get();
        $data['tests'] = DiseaseTest::get();
        $data['diagnose'] = Diagnose::with(['diagnoseConditions','diagnoseConditions.cases'])->findOrFail($id)->toArray();
        return view('admin.diseases.edit',$data);
    }

    public function destroy($id){
        Diagnose::findOrFail($id)->delete();
        session()->flash('success','Disease Deleted!');
        return redirect()->back();
    }
}
