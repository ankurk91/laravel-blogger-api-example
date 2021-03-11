<?php

namespace App\Models;

use App\Models\Traits\HasFeaturedImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    use HasFeaturedImage;

    protected $fillable = [
        'title', 'body', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function scopePublished(Builder $query)
    {
        return $query->whereNotNull('published_at');
    }
}
