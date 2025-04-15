<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 
        'price', 
        'features', 
        'book_limit', 
        'instant_download', 
        'free_trial_days',
        'is_featured',
        'plan_duration'
    ];

    protected $casts = [
        'features' => 'array',
        'instant_download' => 'boolean',
        'is_featured' => 'boolean'
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}