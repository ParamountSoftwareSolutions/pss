<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\SoftDeletes;
>>>>>>> 11b5463d7b2c3aa720aa0cca1591679795e6cc6b

class City extends Model
{
    use HasFactory;
<<<<<<< HEAD
=======
    /*SoftDeletes;


    public function Province(){
        return $this->hasOne(Province::class, 'id', 'province_id');
    }*/

    public function Province(){
        return $this->hasOne(Province::class, 'id', 'state_id');
    }
>>>>>>> 11b5463d7b2c3aa720aa0cca1591679795e6cc6b
}
