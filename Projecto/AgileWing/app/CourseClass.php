<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Course;
use App\ScheduleAtribution;
use App\HourBlockCourse;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseClass extends Model
{
    use SoftDeletes;
    
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function scheduleAtributions()
    {
        return $this->hasMany(ScheduleAtribution::class);
    }

    public function hourBlockCourseClasses()
    {
        return $this->hasMany(HourBlockCourseClass::class);
    }
}