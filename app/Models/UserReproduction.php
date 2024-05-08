<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReproduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'song_id',
        'reproductions',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}
