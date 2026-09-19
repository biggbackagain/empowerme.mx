<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'user_id',
        'payment_id',
        'status',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
