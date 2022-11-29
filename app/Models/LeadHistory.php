<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadHistory extends Model
{
    use HasFactory;

    protected $fillable = ['id ','lead_id','status','comment','date','call_status','start_time','end_time','call_time','is_read'];
}
