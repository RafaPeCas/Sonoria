<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payMethod_id',
        'address_id',
        'total',
       
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function payMethod()
    {
        return $this->belongsTo(PayMethod::class);
    }
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
