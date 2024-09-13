<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssessmentTest;
use Illuminate\Http\Request;

class AssessmentTestController extends Controller
{
    public function index(){
        $tests = AssessmentTest::where(['facility_id' => request()->facility_id])->with(['assessment','assessment.patient','test'])->get();
        return $this->success('Got Tests',$tests);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'test_id' => 'required|exists:disease_tests,id',
            'assessment_id' => 'required|exists:assessments,id'
        ]);
        $validated['facility_id'] = $request->facility_id;
        $validated['status'] = 'Pending';
        $assessmentTest = AssessmentTest::create($validated);
        return $this->success('Test Ordered!',$assessmentTest);
    }

    public function update(Request $request, $id){
        $request->validate([
            'status' => 'required|in:Pending,Completed',
            'notes' => 'nullable',
            'attachment' => 'required|file'
        ]);
        $toUpdate = $request->only(['status','notes']);

        $fileName = time().'.'.$request->file('attachment')->getClientOriginalExtension();
        $request->file('attachment')->move(public_path('uploaded_data'),$fileName);
        $toUpdate['file'] = $fileName;

        AssessmentTest::findOrFail($id)->update($toUpdate);
        $test = AssessmentTest::findOrFail($id);
        return $this->success('Test Updated',$test);
    }
}
