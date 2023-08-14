<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Course;
use App\ScheduleAtribution;

class CourseClass extends Model
{
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function scheduleAtributions()
    {
        return $this->hasMany(ScheduleAtribution::class);
    }
}
