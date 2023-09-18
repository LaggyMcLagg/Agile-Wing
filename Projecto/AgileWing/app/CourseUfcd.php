<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseUfcd extends Model
{
    use SoftDeletes;

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function ufcd()
    {
        return $this->belongsTo(Ufcd::class, 'ufcd_id');
    }


    protected $fillable = [
        'course_id',
        'ufcd_id',

    ];
}
