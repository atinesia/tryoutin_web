<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'reference',       // Added for mass assignment
        'merchant_ref',
        'user_id',
        'exam_id',
        'payment_method',
        'payment_name',
        'amount',
        'pay_code',
        'qr_url',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
