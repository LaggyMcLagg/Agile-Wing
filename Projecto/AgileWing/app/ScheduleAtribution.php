<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScheduleAtribution extends Model
{
    use SoftDeletes;

    public function availabilityType()
    {
        return $this->belongsTo(AvailabilityType::class, 'availability_type_id');
    }

    public function courseClass()
    {
        return $this->belongsTo(CourseClass::class, 'course_class_id');
    }

    public function ufcd()
    {
        return $this->belongsTo(Ufcd::class, 'ufcd_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //to use it as a formatable date
    protected $casts = [
        'date' => 'datetime',
        'hour_start' => 'datetime',
        'hour_end' => 'datetime',
    ];
    //OR

    protected $fillable = [
        'date',
        'hour_block_course_class_id',
        'availability_type_id',
        'course_class_id',
        'ufcd_id',
        'user_id'
    ];

}
