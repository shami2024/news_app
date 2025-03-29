<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use TCG\Voyager\Models\Post;

class User extends \TCG\Voyager\Models\User
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
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
        'password' => 'hashed',
    ];

    public function profile()
{
    return $this->hasOne(Profile::class);
}

public function savedPosts()
{
    return $this->hasMany(SavedPost::class);
}

public function likes()
{
    return $this->hasMany(Like::class);
}

public function comments()
{
    return $this->hasMany(Comment::class);
}

public function shares()
{
    return $this->hasMany(Share::class);
}

public function viewLogs()
{
    return $this->hasMany(ViewLog::class);
}


public function likedPosts()
{
    return $this->belongsToMany(Post::class, 'likes')->withTimestamps();
}

public function hasLikedPost($postId)
{
    return $this->likedPosts()->where('post_id', $postId)->exists();
}

}
