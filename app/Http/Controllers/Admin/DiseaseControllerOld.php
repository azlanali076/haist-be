<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diagnose;
use App\Models\DiagnoseCriteria;
use App\Models\DiagnoseSymptom;
use App\Models\DiagnoseTest;
use App\Models\DiseaseTest;
use App\Models\Symptom;
use Illuminate\Http\Request;

class DiseaseControllerOld extends Controller
{

    private $inputFields = [
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
            'type' => 'number',
            'name' => 'compulsory_symptoms',
            'id' => 'compulsory_symptoms',
            'placeholder' => '# of Compulsory Symptoms',
            'min' => 1,
            'step' => 1,
            'label' => '# of Compulsory Symptoms',
            'required' => true,
            'options' => []
        ],
        [
            'type' => 'number',
            'name' => 'compulsory_criteria',
            'id' => 'compulsory_criteria',
            'placeholder' => '# of Compulsory Criteria',
            'min' => 0,
            'step' => 1,
            'label' => '# of Compulsory Criteria',
            'required' => true,
            'options' => []
        ],
        [
            'type' => 'select',
            'name' => 'check_current_saturation',
            'id' => 'check_current_saturation',
            'placeholder' => 'Check Saturation Difference?',
            'label' => 'Check Saturation Difference?',
            'required' => false,
            'options' => [
                ['label' => 'Yes','value' => 1],
                ['label' => 'No','value' => 0]
            ]
        ],
        [
            'type' => 'number',
            'name' => 'saturation_difference_value',
            'id' => 'saturation_difference_value',
            'placeholder' => 'O2 Saturation Difference Value',
            'min' => 1,
            'step' => 0.01,
            'label' => 'O2 Saturation Difference Value',
            'required' => false,
            'options' => []
        ]
    ];

    public function index(){
        $data['diseases'] = Diagnose::get();
        return view('admin.diseases.index',$data);
    }

    public function create(){
        $data['symptoms'] = Symptom::get();
        $data['fields'] = $this->inputFields;
//        $data['fields'][] = [
//            'type' => 'select',
//            'name' => 'symptom_ids[]',
//            'id' => 'symptom_ids',
//            'placeholder' => 'Select Symptoms',
//            'label' => 'Symptom',
//            'required' => true,
//            'multiple' => true,
//            'options' => $data['symptoms']->map(fn ($symptom) => ['value' => $symptom->id,'label' => $symptom->name])->toArray(),
//        ];
        $data['fields'][] = [
            'type' => 'select',
            'name' => 'must_include_symptom_ids[]',
            'id' => 'must_include_symptom_ids',
            'placeholder' => 'Select Must Include Symptoms',
            'label' => 'Must Include Symptoms',
            'required' => false,
            'multiple' => true,
            'options' => $data['symptoms']->map(fn ($symptom) => ['value' => $symptom->id,'label' => $symptom->name])->toArray()
        ];
        $data['fields'][] = [
            'type' => 'select',
            'name' => 'criteria_ids[]',
            'id' => 'criteria_ids',
            'label' => 'Criteria',
            'required' => false,
            'options' => DiagnoseCriteria::get()->map(fn ($criteria) => ['value' => $criteria->id,'label' => $criteria->name])->toArray(),
            'placeholder' => 'Select Criteria',
            'multiple' => true
        ];
        $data['fields'][] = [
            'type' => 'select',
            'name' => 'must_include_criteria_ids[]',
            'id' => 'must_include_criteria_ids',
            'label' => 'Must Include Criteria',
            'required' => false,
            'options' => DiagnoseCriteria::get()->map(fn ($criteria) => ['value' => $criteria->id,'label' => $criteria->name])->toArray(),
            'placeholder' => 'Select Must Include Criteria',
            'multiple' => true
        ];
        $data['fields'][] = [
            'type' => 'select',
            'name' => 'last_criteria_if_all_fails',
            'id' => 'last_criteria_if_all_fails',
            'label' => 'Last Criteria if All Fails to fulfil',
            'required' => false,
            'options' => DiagnoseCriteria::get()->map(fn ($criteria) => ['value' => $criteria->id,'label' => $criteria->name])->toArray(),
            'placeholder' => 'Select Fallback Criteria'
        ];
        $data['fields'][] = [
            'type' => 'select',
            'name' => 'test_ids[]',
            'id' => 'test_ids',
            'label' => 'Suggested Tests',
            'required' => false,
            'options' => DiseaseTest::get()->map(fn ($test) => ['value' => $test->id,'label' => $test->name])->toArray(),
            'placeholder' => 'Select Tests',
            'multiple' => true
        ];
        return view('admin.diseases.create',$data);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'compulsory_symptoms' => 'required|gt:0',
//            'symptom_ids' => 'required|array',
//            'symptom_ids.*' => 'exists:symptoms,id',
            'criteria_ids' => 'required|array',
            'criteria_ids.*' => 'exists:diagnose_criterias,id',
            'must_include_symptom_ids' => 'nullable|array',
            'must_include_symptom_ids.*' => 'exists:symptoms,id',
            'last_criteria_if_all_fails' => 'nullable|exists:diagnose_criterias,id',
            'must_include_criteria_ids' => 'nullable|array',
            'must_include_criteria_ids.*' => 'exists:diagnose_criterias,id',
            'test_ids' => 'nullable|array',
            'test_ids.*' => 'exists:disease_tests,id',
            'check_current_saturation' => 'nullable|boolean',
            'saturation_difference_value' => 'nullable',
            'symptoms' => 'required|array',
            'symptoms.*.symptom_id' => 'exists:symptoms,id',
            'symptoms.*.times' => 'numeric'
        ]);
        $diagnose = Diagnose::create($request->except(['test_ids','_token','symptoms']));
        if($request->symptoms and count($request->symptoms) > 0) {
            foreach ($request->symptoms as $symptom) {
                DiagnoseSymptom::create([
                    'diagnose_id' => $diagnose->id,
                    'symptom_id' => $symptom['symptom_id'],
                    'times' => $symptom['times']
                ]);
            }
        }
        if($request->test_ids and count($request->test_ids) > 0) {
            foreach ($request->test_ids as $test_id) {
                DiagnoseTest::create([
                    'diagnose_id' => $diagnose->id,
                    'test_id' => $test_id
                ]);
            }
        }
        session()->flash('success','Disease Added!');
        return redirect(route('diseases.index'));
    }

    public function edit($id){
        $data['symptoms'] = Symptom::get();
        $data['fields'] = $this->inputFields;
//        $data['fields'][] = [
//            'type' => 'select',
//            'name' => 'symptom_ids[]',
//            'id' => 'symptom_ids',
//            'placeholder' => 'Select Symptoms',
//            'label' => 'Symptom',
//            'required' => true,
//            'multiple' => true,
//            'options' => $data['symptoms']->map(fn ($symptom) => ['value' => $symptom->id,'label' => $symptom->name])->toArray()
//        ];
        $data['fields'][] = [
            'type' => 'select',
            'name' => 'last_criteria_if_all_fails',
            'id' => 'last_criteria_if_all_fails',
            'label' => 'Last Criteria if All Fails to fulfil',
            'required' => false,
            'options' => DiagnoseCriteria::get()->map(fn ($criteria) => ['value' => $criteria->id,'label' => $criteria->name])->toArray(),
            'placeholder' => 'Select Fallback Criteria'
        ];
        $data['criterias'] = DiagnoseCriteria::get();
        $data['tests'] = DiseaseTest::get();
        $data['disease'] = Diagnose::with(['tests'])->findOrFail($id);
        return view('admin.diseases.edit',$data);
    }

    public function update(Request $request,$id){
        $request->validate([
            'name' => 'required',
            'compulsory_symptoms' => 'required|gt:0',
//            'symptom_ids' => 'required|array',
//            'symptom_ids.*' => 'exists:symptoms,id',
            'criteria_ids' => 'required|array',
            'criteria_ids.*' => 'exists:diagnose_criterias,id',
            'must_include_symptom_ids' => 'nullable|array',
            'must_include_symptom_ids.*' => 'exists:symptoms,id',
            'last_criteria_if_all_fails' => 'nullable|exists:diagnose_criterias,id',
            'must_include_criteria_ids' => 'nullable|array',
            'must_include_criteria_ids.*' => 'exists:diagnose_criterias,id',
            'test_ids' => 'nullable|array',
            'test_ids.*' => 'exists:disease_tests,id',
            'check_current_saturation' => 'nullable|boolean',
            'saturation_difference_value' => 'nullable',
            'symptoms' => 'required|array',
            'symptoms.*.symptom_id' => 'exists:symptoms,id',
            'symptoms.*.times' => 'numeric'
        ]);
        $updateData = $request->except(['_token','_method','test_ids','symptoms']);
        if (!$request->must_include_criteria_ids) {
            $updateData['must_include_criteria_ids'] = [];
        }
        if (!$request->must_include_symptom_ids) {
            $updateData['must_include_symptom_ids'] = [];
        }
        if (!$request->criteria_ids) {
            $updateData['criteria_ids'] = [];
        }
        Diagnose::findOrFail($id)->update($updateData);
        if($request->test_ids and count($request->test_ids) > 0) {
            foreach ($request->test_ids as $test_id) {
                DiagnoseTest::updateOrCreate([
                    'test_id' => $test_id,
                    'diagnose_id' => $id
                ],[
                    'test_id' => $test_id,
                    'diagnose_id' => $id
                ]);
            }
        }
        else{
            DiagnoseTest::where(['diagnose_id' => $id])->delete();
        }
        if($request->symptoms and count($request->symptoms) > 0) {
            foreach ($request->symptoms as $symptom) {
                DiagnoseSymptom::updateOrCreate([
                    'symptom_id' => $symptom['symptom_id'],
                    'times' => $symptom['times'],
                    'diagnose_id' => $id
                ],[
                    'symptom_id' => $symptom['symptom_id'],
                    'times' => $symptom['times'],
                    'diagnose_id' => $id
                ]);
            }
        }
        else{
            DiagnoseSymptom::where(['diagnose_id' => $id])->delete();
        }
        session()->flash('success','Disease Updated!');
        return redirect(route('diseases.index'));
    }

    public function destroy($id){
        Diagnose::findOrFail($id)->delete();
        session()->flash('success','Disease Deleted!');
        return redirect(route('diseases.index'));
    }
}
