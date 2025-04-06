<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'description', 'image','price', 'publish_date', 'pdf_link', 'publish_house_id', 'category_id', 'published_by', 'author_id'];

    // Relationships
    public function publisher()
    {
        return $this->belongsTo(User::class, 'published_by');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function publishingHouse()
    {
        return $this->belongsTo(PublishingHouse::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function audioVersions()
    {
        return $this->hasMany(AudioVersion::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // In Book model
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByPublisher($query, $publisherId)
    {
        return $query->where('published_by', $publisherId);
    }

}
