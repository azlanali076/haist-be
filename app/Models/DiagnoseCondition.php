<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiagnoseCondition extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function diagnose(): BelongsTo
    {
        return $this->belongsTo(Diagnose::class,'diagnose_id','id');
    }

    public function cases(): HasMany
    {
        return $this->hasMany(DiagnoseCase::class,'diagnose_condition_id','id');
    }

}
