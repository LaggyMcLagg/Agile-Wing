<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use App\Course;

class SpecializationArea extends Model
{
    use SoftDeletes;
    
    //Since the primary key is not 'id' but 'number' so that laravel knows
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
