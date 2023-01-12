<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmhouse extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function files()
    {
        return $this->hasMany(FarmhouseFile::class, 'farmhouse_id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
