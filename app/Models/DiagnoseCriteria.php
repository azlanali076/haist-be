<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnoseCriteria extends Model
{
    use HasFactory;
    protected $table = 'diagnose_criterias';
    protected $guarded = [];
    protected $casts = ['symptom_ids' => 'array'];

    public function diagnose(){
        return $this->belongsTo(Diagnose::class,'diagnose_id','id');
    }

    public function symptoms(){
        return Symptom::findMany($this->symptom_ids);
    }

    public function case(){
        return $this->morphMany(DiagnoseCase::class,'case');
    }
}
