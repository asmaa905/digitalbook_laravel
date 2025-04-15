<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioVersion extends Model
{
    use HasFactory;
    protected $fillable = ['book_id', 'audio_link', 'created_by', 'audio_duration', 'language', 'is_published', 'review_record_link'];

    // Relationships
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function getFormattedDurationAttribute()
    {
        $hours = floor($this->audio_duration / 3600);
        $minutes = floor(($this->audio_duration % 3600) / 60);
        $seconds = $this->audio_duration % 60;
        
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
}
