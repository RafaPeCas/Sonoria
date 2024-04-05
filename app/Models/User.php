<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'birth',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function addresses(){
        return $this->hasMany(Address::class);
    }
    public function albums()
    {
        return $this->hasMany(Album::class);
    }
    public function paymentMethod()
    {
        return $this->hasOne(PayMethod::class);
    }
    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function searches()
    {
        return $this->hasMany(Search::class);
    }
    public function songs()
    {
        return $this->hasMany(Song::class);
    }
    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'user_playlist');
    }
    public function roles()
    {
        return $this->hasMany(Role::class);
    }
    public function reproductions()
    {
        return $this->hasMany(UserReproduction::class);
    }
}
