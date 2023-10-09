<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\PedagogicalGroup;
use App\Ufcd;
use App\UserType;
use App\TeacherAvailability;
use App\SpecializationArea;
use App\ScheduleAtribution;
use App\HourBlockCourse;


class User extends Authenticatable implements MustVerifyEmail

{
    use SoftDeletes;

    use Notifiable;

    public function pedagogicalGroups()
    {
        return $this->belongsToMany(PedagogicalGroup::class, 'pedagogical_group_users');
    }

    public function ufcds()
    {
        return $this->belongsToMany(Ufcd::class, 'user_ufcds');
    }

    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }

    public function teacherAvailabilities()
    {
        return $this->hasMany(TeacherAvailability::class);
    }

    public function specializationAreas()
    {
        return $this->belongsToMany(SpecializationArea::class, 'specialization_area_users', 'user_id', 'specialization_area_number');
    }

    public function scheduleAtributions()
    {
        return $this->hasMany(ScheduleAtribution::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type_id',
        'notes',
        'color_1',
        'color_2',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



}
