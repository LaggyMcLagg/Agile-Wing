<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Ufcd;
use Illuminate\Database\Eloquent\SoftDeletes;

class PedagogicalGroup extends Model
{
    use SoftDeletes;
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'pedagogical_group_users');
    }

    public function ufcds()
    {
        return $this->hasMany(Ufcd::class);
    }
}
