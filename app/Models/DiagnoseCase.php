<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class DiagnoseCase extends Model
{
    use HasFactory;
    protected $table = 'diagnose_cases';
    protected $guarded = [];

    public function diagnose(): BelongsTo
    {
        return $this->belongsTo(Diagnose::class,'diagnose_id','id');
    }

    public function diagnoseCondition(): BelongsTo
    {
        return $this->belongsTo(DiagnoseCondition::class,'diagnose_condition_id','id');
    }

    public function case(): MorphTo
    {
        return $this->morphTo();
    }
}
