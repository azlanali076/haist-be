<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index () {
        $facility = Facility::findOrFail(request()->user()->facility_id);
        return $this->success('Facility',$facility);
    }
}
