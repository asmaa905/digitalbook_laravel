<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
 use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
   
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
  protected $fillable = [
    'name', 'email', 'phone', 'password', 'image', 'role','social_id','social_type'
];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    use HasFactory, SoftDeletes;

  

    // Relationships
    //one user has many reviews
    //and has many books created
    public function audioVersionsCreated()
    {
        return $this->hasMany(AudioVersion::class, 'created_by');
    }
    // and has many books audio version publish for every book
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    // app/Models/User.php

        // For readers
        public function readedBooks()
        {
            return $this->belongsToMany(Book::class, 'readed_books', 'user_id', 'book_id')
                        ->withPivot('read_date')
                        ->withTimestamps();
        }
       

        // For publishers
        public function publishedBooks()
        {
            return $this->hasMany(Book::class, 'published_by');
        }


        public function subscriptions()
        {
            return $this->hasMany(Subscription::class);
        }

        public function payments()
        {
            return $this->hasMany(Payment::class);
        }
        public function publisher()
        {
            return $this->hasOne(\App\Models\Publisher::class);
        }
        public function canEditUser(User $targetUser)
        {
            // Admins can edit themselves and all non-admin users
            if ($this->role === 'Admin') {
                return $targetUser->id === $this->id || $targetUser->role !== 'Admin';
            }
            
            // Other users can only edit themselves
            return $targetUser->id === $this->id;
        }
        public function getHasActiveSubscriptionAttribute()
        {
            return $this->subscriptions()
                ->where('status', 'confirm')
                ->where(function($query) {
                    $query->where('end_date', '>', now())
                        ->orWhereNull('end_date');
                })
                ->exists();
        } 
        // For readers
        //select favbooks
        public function favBooks()
        {
            return $this->belongsToMany(Book::class, 'fav_books', 'user_id', 'book_id')
                ->withTimestamps();
        }
       

}

