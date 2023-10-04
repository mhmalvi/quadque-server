<?php

namespace App\Models;

use App\Models\Feature;
use App\Models\KeyPoint;
use App\Models\Technology;
use App\Models\UsingPurpose;
use App\Models\SolvedProblem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function keys()
    {
        return $this->hasMany(KeyPoint::class);
    }

    public function plans()
    {
        return $this->hasMany(SolvedProblem::class);
    }

    public function using_purposes()
    {
        return $this->hasMany(UsingPurpose::class);
    }

    public function features()
    {
        return $this->hasMany(Feature::class);
    }
}
