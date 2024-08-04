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
    public function staff_details()
    {
        if ($this->type == 'Doctor') {
            return $this->belongsTo(Doctor::class, 'staff_id')->with(['state', 'city', 'area']);
        }else{
            return $this->belongsTo(Staff::class, 'staff_id')->with(['state', 'city', 'area']);
        }
        return null;
    }
    public function staff()
    {
        return $this->hasOne(Staff::class,'id','staff_id')->with(['state', 'city', 'area', 'types']);
    }
    public function doctor()
    {
        return $this->hasOne(Doctor::class,'id','staff_id')->with(['state', 'city', 'area']);
    }
    public function shift()
    {
        return $this->hasOne(Shifts::class,'id','shift');
    }
    public function shiftt()
    {
        return $this->hasOne(Shifts::class,'id','shift');
    }
    public function updated_by_user()
    {
        return $this->hasOne(User::class,'id','updated_by');
    }
}
