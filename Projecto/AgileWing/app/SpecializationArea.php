<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Course;

class SpecializationArea extends Model
{
    //Since the primary key is not 'id' but number so that laravel knows
    protected $primaryKey = 'number';

    public function users()
    {
        return $this->belongsToMany(User::class, 'specialization_area_users', 'specialization_area_number', 'user_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
