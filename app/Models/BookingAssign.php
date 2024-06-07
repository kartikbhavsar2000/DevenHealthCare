<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingAssign extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "booking_assign";

    public function booking()
    {
        return $this->hasOne(Booking::class,'id','booking_id');
    }
}
