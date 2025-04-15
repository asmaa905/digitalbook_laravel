<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model 
{
    use HasFactory;
    
    protected $fillable = [
        'plan_id',
        'user_id', 
        'payment_id',
        'start_date', 
        'end_date',
        'status',
        'is_active'
    ];
    
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    // One-to-one relationship with payment
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    // One-to-many relationship (if you need history)
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function isActive()
    {
        return $this->is_active && ($this->end_date === null || $this->end_date->isFuture());
    }
}