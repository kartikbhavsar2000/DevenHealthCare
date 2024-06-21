<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "booking_payments";

    public function created_by()
    {
        return $this->hasOne(User::class,'id','added_by');
    }
}
