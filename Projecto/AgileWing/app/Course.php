<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ufcd;
use App\SpecializationArea;
use App\CourseClass;

class Course extends Model
{
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
