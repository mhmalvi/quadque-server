<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function responsibilities(){
        return $this->hasMany(Responsibility::class,'job_id');
    }
    public function requirements()
    {
        return $this->hasMany(Requirement::class, 'job_id');
    }
    public function additionals()
    {
        return $this->hasMany(Additional::class, 'job_id');
    }
}
