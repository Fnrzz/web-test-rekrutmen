<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'thumbnail',
        'url',
    ];

    public function category()
    {
        return $this->belongsTo(VideoCategory::class);
    }
}
