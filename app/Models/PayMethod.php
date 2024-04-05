<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'card_holder',
        'card_number',
        'cvv',
        'deleted',
       
    ];


public function user()
{
    return $this->belongsTo(User::class);
}

public function subscriptions()
{
    return $this->hasMany(Subscription::class);
}

}
