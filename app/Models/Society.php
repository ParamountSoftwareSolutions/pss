<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Society extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function society_file()
    {
        return $this->belongsTo(SocietyFile::class, 'society_id');

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
        return $this->belongsTo(city::class, 'city_id');

    }
}
