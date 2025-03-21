<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Models\Post;

class ViewLog extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'post_id', 'ip'];

    public function post() {
        return $this->belongsTo(Post::class);
    }
}
