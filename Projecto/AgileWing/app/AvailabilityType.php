<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TeacherAvailability;
use App\ScheduleAtribution;

class AvailabilityType extends Model
{
    public function teacherAvailabilities()
    {
        return $this->hasMany(TeacherAvailability::class);
    }

    public function scheduleAtributions()
    {
        return $this->hasMany(ScheduleAtribution::class);
    }
}
