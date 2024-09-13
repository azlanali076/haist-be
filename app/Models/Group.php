<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Group extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = ['facility_ids' => 'array'];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class,'admin_id','id');
    }

    public function facilities(){
        return Facility::findMany($this->facility_ids);
    }
}
