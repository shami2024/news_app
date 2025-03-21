<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Models\Post;

class Interest extends Model
{
    use HasFactory;
    
    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_interests');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'user_interests');
    }

//     public function interests()  in user model
// {
//     return $this->belongsToMany(Interest::class, 'user_interests');
// }



}