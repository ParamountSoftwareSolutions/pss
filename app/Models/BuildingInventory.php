<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingInventory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function premium()
    {
        return $this->belongsTo(Premium::class, 'premium_id');
    }

    public function file()
    {
        return $this->hasMany(BuildingInventoryFile::class, 'building_inventory_id');
    }

}
