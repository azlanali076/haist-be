<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Diagnose extends Model
{
    use HasFactory;
    protected $table = 'diagnoses';
    protected $guarded = [];

    public function tests(): HasManyThrough
    {
        return $this->hasManyThrough(DiseaseTest::class,DiagnoseTest::class,'diagnose_id','id','id','test_id');
    }

    public function diagnoseConditions(): HasMany
    {
        return $this->hasMany(DiagnoseCondition::class,'diagnose_id','id');
    }

    public function cases(): HasMany
    {
        return $this->hasMany(DiagnoseCase::class,'diagnose_id','id');
    }
}
