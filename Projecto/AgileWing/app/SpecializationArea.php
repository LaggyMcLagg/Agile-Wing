<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use App\Course;

class SpecializationArea extends Model
{
    use SoftDeletes;

    public function users()
    {
        return $this->belongsToMany(User::class, 'specialization_area_users', 'specialization_area_id', 'user_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    protected $fillable = [
        'name',
        'number',
    ];
}
