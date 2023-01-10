<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function type()
    {
        return $this->belongsTo(ProjectType::class, 'type_id');
    }

    public function building_detail()
    {
        return $this->hasOne(BuildingDetail::class, 'project_id');
    }
}
