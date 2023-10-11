<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PedagogicalGroupUser extends Model
{
    use SoftDeletes;
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function pedagogicalGroup()
    {
        return $this->belongsTo(pedagogicalGroup::class, 'pedagogical_group_id');
    }

    protected $fillable = [
        'user_id', 
        'pedagogical_group_id' 
    ];


}
