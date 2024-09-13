<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentPossibleDisease extends Model
{
    use HasFactory;
    protected $table = 'assessment_possible_diseases';
    protected $guarded = [];

    public function assessment(){
        return $this->belongsTo(Assessment::class,'assessment_id','id');
    }

    public function disease(){
        return $this->belongsTo(Diagnose::class,'disease_id','id');
    }
}
