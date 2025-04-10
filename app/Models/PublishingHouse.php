<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PublishingHouse extends Model {
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'location', 'website', 'image'];

    public function publishers() {
        return $this->hasMany(Publisher::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class, 'publish_house_id');
    }
}