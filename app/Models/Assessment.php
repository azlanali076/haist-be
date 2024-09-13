<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Assessment extends Model
{
    use HasFactory;
    protected $table = 'assessments';
    protected $guarded = [];

    public function symptoms(): HasManyThrough
    {
        return $this->hasManyThrough(Symptom::class,AssessmentSymptom::class,'assessment_id','id','id','symptom_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class,'patient_id','id');
    }

    public function possibleDiseases(): HasManyThrough
    {
//        return $this->hasMany(AssessmentPossibleDisease::class,'assessment_id','id');
//        return $this->hasManyThrough(Diagnose::class,AssessmentPossibleDisease::class,'disease_id','id','id','assessment_id');
        return $this->hasManyThrough(Diagnose::class,AssessmentPossibleDisease::class,'assessment_id','id','id','disease_id');
    }

    public function diagnose(): BelongsTo
    {
        return $this->belongsTo(Diagnose::class,'diagnose_id','id');
    }

    public function tests(): HasMany
    {
        return $this->hasMany(AssessmentTest::class,'assessment_id','id');
    }

    public function nurse(): BelongsTo
    {
        return $this->belongsTo(User::class,'nurse_id','id');
    }

    public function scopeByStatus($query,$status = null) {
        if($status) {
            return $query->where('status',$status);
        }
        return $query;
    }
}
