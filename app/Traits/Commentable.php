<?php
/**
 * Created by PhpStorm.
 * User: sabanovin
 * Date: 01/14/2019
 * Time: 04:40 PM
 */

namespace App\Traits;


use App\Models\Comment;

trait Commentable
{
    public function comments()
    {
        return $this->morphMany(Comment::class , 'commentable');
    }
}