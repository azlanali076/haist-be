<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentTest extends Model
{
    use HasFactory;
    protected $table = 'assessment_tests';
    protected $guarded = [];

    public const STATUS_PENDING = 'Pending';
    public const STATUS_COMPLETED = 'Completed';

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class,'facility_id','id');
    }

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class,'assessment_id','id');
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(DiseaseTest::class,'test_id','id');
    }

    public function scopeByStatus($query, $status){
        if($status){
            return $query->where('status','=',$status);
        }
        return $query;
    }

    public function scopeByDateFrom($query, $dateFrom) {
        if($dateFrom) {
            return $query->whereDate('created_at','>=',$dateFrom);
        }
        return $query;
    }
}
