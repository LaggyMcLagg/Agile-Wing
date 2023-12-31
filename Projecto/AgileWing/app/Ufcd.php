<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\PedagogicalGroup;
use App\Course;
use App\User;
use App\ScheduleAtribution;


class Ufcd extends Model
{
    use SoftDeletes;
    
    public function pedagogicalGroup()
    {
        return $this->belongsTo(PedagogicalGroup::class, 'pedagogical_group_id');
    }

    public function courses() {
        return $this->belongsToMany(Course::class, 'course_ufcds');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_ufcds');
    }

    public function scheduleAtributions()
    {
        return $this->hasMany(ScheduleAtribution::class);
    }

    protected $fillable = [
        'name',
        'pedagogical_group_id',
        'number',
        'hours'
        ];
}
