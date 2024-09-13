<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssessmentSymptom;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function symptoms(){
        $symptomsChart = AssessmentSymptom::whereDate('created_at','>=',Carbon::now()->subDays(30))
            ->selectRaw('COUNT(id) AS times,DAY(created_at) as day')->groupByRaw('DAY(created_at)')->get()->pluck('times','day');
        return $this->success('',$symptomsChart);
    }
}
