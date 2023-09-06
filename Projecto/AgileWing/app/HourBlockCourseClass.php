<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\CourseClass;

class HourBlockCourseClass extends Model
{
    use SoftDeletes;
    
    public function courseClass()
    {
        return $this->belongsTo(CourseClass::class);
    }

}
