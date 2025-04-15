<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 
        'subscription_id', 
        'total_amount', 
        'payment_method', 
        'transaction_id',
        'status',
        'invoice_reference',
        'paid_date',
        'card_number'
    ];

    protected $casts = [
        'paid_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}