<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Publisher extends Model {
    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id', 'identity', 'job_title', 'publishing_house_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function publishingHouse() {
        return $this->belongsTo(PublishingHouse::class);
    }
}