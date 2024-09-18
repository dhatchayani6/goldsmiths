<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    public function jewel()
    {
        return $this->belongsTo(Jewel::class);
    }

    protected $fillable = [
        'jewel_id',
        'amount',
        'customer_name',
        'email',
        'mobile_number',
        'zip_code',
        'address',
        'payment_method',
        'card_name',
        'card_number',
        'expiry_date',
        'cvv',
        'razorpay_payment_id',
    ];
}
