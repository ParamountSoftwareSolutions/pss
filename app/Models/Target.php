<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    public function assign()
    {
        return $this->belongsTo(User::class, 'assign_to');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
