<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payMethod_id',

        'active',
        'name',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function paymentMethod()
    {
        return $this->belongsTo(PayMethod::class, 'payMethod_id');
    }
}
