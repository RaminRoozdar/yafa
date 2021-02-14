<?php
/**
 * Created by PhpStorm.
 * User: sabanovin
 * Date: 01/16/2019
 * Time: 12:31 PM
 */

namespace App\Traits;


use App\Models\Tag;

trait Taggables
{
    public function tags()
    {
        return $this->morphToMany(Tag::class , 'taggable');
    }
}
