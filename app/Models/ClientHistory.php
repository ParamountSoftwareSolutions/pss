<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientHistory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function from()
    {
        return $this->belongsTo(Client::class,'client_id');
    }

    public function to()
    {
        return $this->belongsTo(Client::class,'transfer_to');
    }
    public function sale_person()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
