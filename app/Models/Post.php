<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
  
        static::created(function ($post) {
            $post->slug = $post->createSlug($post->title);
            $post->save();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    private function createSlug($title){
        $slug = Str::slug($title);

        if (Post::where('slug', $slug)->exists()) {
            $suffix = 1;
            while (Post::where('slug', $slug . '-' . $suffix)->exists()) {
                $suffix++;
            }
            $slug = $slug . '-' . $suffix;
        }
    
        return $slug;
    }
}
