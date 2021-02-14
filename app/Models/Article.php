<?php

namespace App\Models;

use App\Traits\Commentable;
use App\Traits\Taggables;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Commentable , Taggables;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
