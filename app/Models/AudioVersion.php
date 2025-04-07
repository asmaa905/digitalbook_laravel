<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioVersion extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'audio_link', 'created_by','language'];

    // Relationships
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
