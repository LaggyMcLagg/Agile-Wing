<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\TeacherAvailability;

class HourBlock extends Model
{
    use SoftDeletes;
    
    public function teacherAvailabilities()
    {
        return $this->hasMany(TeacherAvailability::class);
    }

    protected $fillable = [
        'hour_beginning',
        'hour_end'
    ];
}
