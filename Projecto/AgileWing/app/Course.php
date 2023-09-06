<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Ufcd;
use App\SpecializationArea;
use App\CourseClass;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;
    
    public function specializationArea()
    {
        return $this->belongsTo(SpecializationArea::class, 'specialization_area_number');
    }

    public function courseClasses()
    {
        return $this->hasMany(CourseClass::class);
    }
    
    public function ufcds() {
        return $this->belongsToMany(Ufcd::class, 'course_ufcds');
    }
}
