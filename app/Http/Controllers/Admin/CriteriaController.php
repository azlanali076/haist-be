<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiagnoseCriteria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CriteriaController extends Controller
{
    private $inputFields = [
        [
            'type' => 'text',
            'label' => 'Name',
            'name' => 'name',
            'id' => 'name',
            'placeholder' => 'Enter name',
            'options' => [],
            'required' => true
        ],
    ];

    public function index(){
        $data['criterias'] = DiagnoseCriteria::get();
        return view('admin.criterias.index',$data);
    }

    public function create(){
        $data['fields'] = $this->inputFields;
        $data['fields'][] = [
            'type' => 'select',
            'label' => 'Criteria Based on',
            'name' => 'criteria_key',
            'id' => 'criteria_key',
            'placeholder' => 'Select Criteria',
            'options' => collect(config('constants.criteria'))->map(fn ($value) => ['label' => $value['name'],'value' => $value['key']])->toArray(),
            'required' => true
        ];
        $data['fields'][] = [
            'type' => 'select',
            'name' => 'criteria_comparison_operator',
            'id' => 'criteria_comparison_operator',
            'label' => 'Comparison Operator',
            'placeholder' => 'Enter Comparison Operator',
            'required' => true,
            'options' => collect(config('constants.comparison_operators'))->map(fn ($value) => ['label' => $value['name'],'value' => $value['key']])->toArray()
        ];
        $data['fields'][] = [
            'type' => 'number',
            'step' => '0.01',
            'name' => 'criteria_value',
            'id' => 'criteria_value',
            'label' => 'Criteria Value / SYSTOLIC mm Hg (upper number)',
            'placeholder' => 'Enter Criteria Value / SYSTOLIC mm Hg (upper number)',
            'options' => [],
            'required' => true
        ];
        $data['fields'][] = [
            'type' => 'number',
            'step' => '0.01',
            'name' => 'blood_pressure_down_value',
            'id' => 'blood_pressure_down_value',
            'label' => 'DIASTOLIC mm Hg (Lower Number) (Required if Criteria is based on Blood Pressure)',
            'placeholder' => 'Enter DIASTOLIC mm Hg (Lower Number)',
            'options' => [],
            'required' => false
        ];
        return view('admin.criterias.create',$data);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'criteria_value' => 'required',
            'criteria_key' => ['required',Rule::in(array_keys(config('constants.criteria')))],
            'criteria_comparison_operator' => ['required',Rule::in(array_keys(config('constants.comparison_operators')))],
            'blood_pressure_down_value' => [Rule::requiredIf($request->criteria_key == config('constants.criteria.blood_pressure.key'))]
        ],[],[
            'blood_pressure_down_value' => 'DIASTOLIC mm Hg (Lower Number)'
        ]);
        $diagnoseCriteria = DiagnoseCriteria::create($validated);
        session()->flash('success','Diagnose Criteria Added!');
        return redirect(route('criteria.index'));
    }

    public function edit($id){
        $data['fields'] = $this->inputFields;
        $data['fields'][] = [
            'type' => 'select',
            'label' => 'Criteria Based on',
            'name' => 'criteria_key',
            'id' => 'criteria_key',
            'placeholder' => 'Select Criteria',
            'options' => collect(config('constants.criteria'))->map(fn ($value) => ['label' => $value['name'],'value' => $value['key']])->toArray(),
            'required' => true
        ];
        $data['fields'][] = [
            'type' => 'select',
            'name' => 'criteria_comparison_operator',
            'id' => 'criteria_comparison_operator',
            'label' => 'Comparison Operator',
            'placeholder' => 'Enter Comparison Operator',
            'required' => true,
            'options' => collect(config('constants.comparison_operators'))->map(fn ($value) => ['label' => $value['name'],'value' => $value['key']])->toArray()
        ];
        $data['fields'][] = [
            'type' => 'number',
            'step' => '0.01',
            'name' => 'criteria_value',
            'id' => 'criteria_value',
            'label' => 'Criteria Value / SYSTOLIC mm Hg (upper number)',
            'placeholder' => 'Enter Criteria Value / SYSTOLIC mm Hg (upper number)',
            'options' => [],
            'required' => true
        ];
        $data['fields'][] = [
            'type' => 'number',
            'step' => '0.01',
            'name' => 'blood_pressure_down_value',
            'id' => 'blood_pressure_down_value',
            'label' => 'DIASTOLIC mm Hg (Lower Number) (Required if Criteria is based on Blood Pressure)',
            'placeholder' => 'Enter DIASTOLIC mm Hg (Lower Number)',
            'options' => [],
            'required' => false
        ];
        $data['criteria'] = DiagnoseCriteria::findOrFail($id);
        return view('admin.criterias.edit',$data);
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required',
            'criteria_value' => 'required',
            'criteria_key' => ['required',Rule::in(array_keys(config('constants.criteria')))],
            'criteria_comparison_operator' => ['required',Rule::in(array_keys(config('constants.comparison_operators')))],
            'blood_pressure_down_value' => [Rule::requiredIf($request->criteria_key == config('constants.criteria.blood_pressure.key'))]
        ],[],[
            'blood_pressure_down_value' => 'DIASTOLIC mm Hg (Lower Number)'
        ]);
        DiagnoseCriteria::findOrFail($id)->update($validated);
        session()->flash('success','Diagnose Criteria Updated!');
        return redirect(route('criteria.index'));
    }

    public function destroy($id){
        DiagnoseCriteria::findOrFail($id)->delete();
        session()->flash('success','Diagnose Criteria Deleted!');
        return redirect()->back();
    }
}
