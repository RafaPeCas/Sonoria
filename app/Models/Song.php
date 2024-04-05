<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'file',
        'explicit',
        'active',
        'hidden',
        'name',
        'reproductions',
        'image',
        'album_id',
    ];
    public function genres()
    {
    return $this->belongsToMany(Genre::class, 'genre_song');
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_song');
    }
    public function album()
    {
    return $this->belongsTo(Album::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_song');
    }
    public function reproductions()
    {
        return $this->hasMany(UserReproduction::class);
    }
   
}
