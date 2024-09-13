<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacilityAdmin extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class,'facility_id','id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class,'admin_id','id');
    }
}
