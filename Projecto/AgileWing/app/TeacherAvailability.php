<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
