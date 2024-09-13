<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiagnoseTest extends Model
{
    use HasFactory;
    protected $table = 'diagnose_tests';
    protected $guarded = [];

    public function diagnose(): BelongsTo
    {
        return $this->belongsTo(Diagnose::class,'diagnose_id','id');
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(DiseaseTest::class,'test_id','id');
    }
}
