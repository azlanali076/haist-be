<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiseaseTest extends Model
{
    use HasFactory;
    protected $table = 'disease_tests';
    protected $guarded = [];
}
