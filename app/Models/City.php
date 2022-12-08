<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory;
    /*SoftDeletes;


    public function Province(){
        return $this->hasOne(Province::class, 'id', 'province_id');
    }*/

    public function Province(){
        return $this->hasOne(Province::class, 'id', 'state_id');
    }
}
