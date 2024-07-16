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
    public function staff()
    {
        return $this->hasOne(Staff::class,'id','staff_id');
    }
    public function shift()
    {
        return $this->hasOne(Shifts::class,'id','shift');
    }
    public function updated_by_user()
    {
        return $this->hasOne(User::class,'id','updated_by');
    }
}
