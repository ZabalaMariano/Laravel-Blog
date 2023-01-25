<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    public function getFollowedUser(){
        return $this->belongsTo(User::class, 'followeduser', 'id');
    }

    public function getUserFollowing(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
