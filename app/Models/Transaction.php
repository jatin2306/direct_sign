<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service',
        'source',
        'amount',
        'status',
        'note',
        'transaction_date',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

