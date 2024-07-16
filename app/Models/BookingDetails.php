<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "booking_details";

    public function booking()
    {
        return $this->hasOne(Booking::class,'id','booking_id');
    }
    public function count()
    {
        return $this->hasMany(BookingAssign::class,'booking_detail_id','id');
    }
}
