<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TeacherAvailability;

class HourBlock extends Model
{
    public function teacherAvailabilities()
    {
        return $this->hasMany(TeacherAvailability::class);
    }
}
