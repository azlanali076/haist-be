<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentSymptom extends Model
{
    use HasFactory;

    protected $table = 'assessment_symptoms';
    protected $guarded = [];

    public function assessment(){
        return $this->belongsTo(Assessment::class,'assessment_id','id');
    }

    public function symptom(){
        return $this->belongsTo(Symptom::class,'symptom_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
