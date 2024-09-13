<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssessmentTest;
use Illuminate\Http\Request;

class AssessmentTestController extends Controller
{
    public function index(){
        $testsQuery = AssessmentTest::where(['facility_id' => request()->user()->facility_id]);
        $data['tests'] = $testsQuery->byStatus(request()->status)->byDateFrom(request()->date_from)->paginate(10);
        return view('admin.assessment-tests.index',$data);
    }
}
