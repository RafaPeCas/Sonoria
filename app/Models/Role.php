<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
