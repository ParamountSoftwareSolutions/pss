<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function project_type()
    {
        return $this->belongsTo(ProjectType::class);
    }
    public function customer()
    {
        return $this->belongsTo(lead::class,'customer_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sale_person()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function installment()
    {
        return $this->hasMany(ClientInstallment::class, 'client_id');
    }
}
