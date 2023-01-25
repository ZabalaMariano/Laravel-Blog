<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(){
        return $this->hasMany(Post::class, 'user_id');
    }

    public function followers(){
        return $this->hasMany(Follow::class, 'followeduser');
    }

    public function following(){
        return $this->hasMany(Follow::class, 'user_id');
    }

    // Get posts of people I follow
    public function feedPosts(){
        // hasManyThrough: when we have an intermediate table in the relationship 
        // User (has follower id) hasMany Follow -> Follow (has follower id & followed id) BelongsTo User -> User hasMany Post (has followed id)

        // 6 arguments
        // 1. the model we want to end up with
        // 2. intermediate table
        // 3. foreign key in intermediate table (follower id in Follow -> user_id)
        // 4. foreign key in final table (followed id in Post -> user_id)
        // 5. local key in first table (follower id in User -> id)
        // 6. local key in intermediate table (followed id in Follow -> followeduser)
        return $this->hasManyThrough(Post::class, Follow::class, 'user_id', 'user_id', 'id', 'followeduser');
    }

    // Accesor: middle step to access user value "avatar".
    // Allows to do something with it before delivering it.
    // function name must be equal to database-table-attribute in User.
    public function avatar(): Attribute {
        return Attribute::make(get: function($value){
            // $value: incoming avatar from database
            // "fallback-avatar.jpg" in public folder
            return $value ? '/storage/avatars/' . $value : '/fallback-avatar.jpg' ;
        });
    }
}
