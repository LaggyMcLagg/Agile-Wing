<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\TeacherAvailability;
use App\ScheduleAtribution;
use Illuminate\Database\Eloquent\SoftDeletes;


class AvailabilityType extends Model
{
    use SoftDeletes;
    
    public function teacherAvailabilities()
    {
        return $this->hasMany(TeacherAvailability::class);
    }

    public function scheduleAtributions()
    {
        return $this->hasMany(ScheduleAtribution::class);
    }
}
