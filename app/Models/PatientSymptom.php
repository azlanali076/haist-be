<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientSymptom extends Model
{
    use HasFactory;
    protected $table = 'patient_symptoms';
    protected $guarded = [];

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class,'facility_id','id');
    }

    public function assistantNurse(): BelongsTo
    {
        return $this->belongsTo(User::class,'assistant_nurse_id','id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class,'patient_id','id');
    }

    public function symptom(): BelongsTo
    {
        return $this->belongsTo(Symptom::class,'symptom_id','id');
    }
}
