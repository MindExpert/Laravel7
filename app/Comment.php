<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
	use softDeletes;

    public function blogPost()
    {
        return $this->belongsTo(BlogPost::class);
    }
}
