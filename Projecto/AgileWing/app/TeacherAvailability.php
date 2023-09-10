<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;


class TeacherAvailability extends Model
{
    use SoftDeletes;

    public function hourBlock()
    {
        return $this->belongsTo(HourBlock::class, 'hour_block_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function availabilityType()
    {
        return $this->belongsTo(AvailabilityType::class, 'availability_type_id');
    }

    //to use it as a formatable date
    protected $casts = [
        'availability_date' => 'datetime',
    ];
    //OR
    // protected $dates = [
    //     'availability_date',
    // ];

    protected $fillable = [
        'availability_date',
        'is_locked', 
        'user_id', 
        'hour_block_id', 
        'availability_type_id'
    ];

}
