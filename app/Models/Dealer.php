<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;

    public function project()
    {
        return $this->belongsToMany(Project::class,'dealer_projects','dealer_id','project_id');
    }

    public function received()
    {
        return $this->hasMany(DealerHistory::class);
    }
}
