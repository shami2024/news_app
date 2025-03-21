<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Models\Post;

class Redaction extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'logo'];

    public function articles()
    {
        return $this->hasMany(Post::class);
    }
}
