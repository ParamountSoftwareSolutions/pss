<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function unit_type($unit)
    {
        return Unit::where('name', $unit)->get();
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function project_type()
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id');
    }
}
