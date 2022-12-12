<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $guarded = [];

    /*public function building_inventory()
    {
        return $this->belongsTo(BuildingInventory::class, 'building_id')->with('building_inventory_file');
    }*/

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function building_file()
    {
        return $this->belongsTo(BuildingFile::class, 'building_id');
    }

    public function building_detail()
    {
        return $this->hasOne(BuildingDetail::class, 'building_id');
    }
}
