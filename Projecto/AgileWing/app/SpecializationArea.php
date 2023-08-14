<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Course;

class SpecializationArea extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'specialization_area_users', 'specialization_area_id', 'user_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
