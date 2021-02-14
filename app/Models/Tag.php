<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function articles()
    {
        return $this->morphedByMany(Article::class , 'taggable');
    }

//    public function news()
//    {
//        return $this->morphedByMany(News::class , 'taggable');
//    }
}
