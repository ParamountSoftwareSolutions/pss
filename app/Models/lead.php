<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lead extends Model
{
    protected $fillable = ['id ','user_id','project_id','created_by','name','email','number','alt_number','father_name','cnic','budget','budget','source','location','country_id','state_id','city_id','status','type','priority'];
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
