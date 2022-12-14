<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{

    use HasFactory;
    protected $guarded = [];
    protected $attributes = [
        'project_id' => "NULL",
    ];
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }
    public function sale_person()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function building()
    {
        return $this->belongsTo(Project::class, 'project_id');
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
    public function lead_histories()
    {
        return $this->hasMany(LeadHistory::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
