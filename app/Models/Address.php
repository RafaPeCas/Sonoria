<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'user_id',
        'province',
        'city',
        'street',
        'number',
        'pc',
        'country',
       
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

}
