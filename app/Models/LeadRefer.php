<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadRefer extends Model
{

    use HasFactory;
    protected $table = 'lead_refer';

    public function lead()
    {
        return $this->belongsTo(Lead::class,'lead_id');
    }
    public function to_user()
    {
        return $this->belongsTo(User::class,'to');
    }
    public function from_user()
    {
        return $this->belongsTo(User::class,'from');
    }
}
