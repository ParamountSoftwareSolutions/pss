<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmhouseInventory extends Model
{
    use HasFactory;

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function nature()
    {
        return $this->belongsTo(type::class, 'type_id');
    }

    public function payment_plan()
    {
        return $this->belongsTo(PaymentPlan::class, 'payment_plan_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function premium()
    {
        return $this->belongsTo(Premium::class, 'premium_id');
    }
}
