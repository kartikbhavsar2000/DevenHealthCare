<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "bookings";

    public function added_by()
    {
        return $this->hasOne(User::class,'id','created_by');
    }
    public function assign_by()
    {
        return $this->hasOne(User::class,'id','assigned_by');
    }
    public function closed_by()
    {
        return $this->hasOne(User::class,'id','closed_by');
    }
    public function bookingDetails()
    {
        return $this->hasMany(BookingDetails::class,'booking_id','id');
    }
    public function bookingAssigns()
    {
        return $this->hasMany(BookingAssign::class,'booking_id','id');
    }
    public function customerDetails()
    {
        if ($this->booking_type == 'Patient') {
            return Patient::where('id', $this->customer_id)->first();
        } elseif ($this->booking_type == 'Corporate') {
            return Corporate::where('id', $this->customer_id)->first();
        }

        return null;
    }

    protected static function booted()
    {
        parent::boot();

        static::creating(function ($booking) {
            $booking->unique_id = self::generateUniqueBookingId();
        });
    }
    private static function generateUniqueBookingId()
    {
        $year = date('Y');
        $prefix = 'DHCB' . $year;

        $lastBooking = self::where('unique_id', 'like', $prefix . '%')->orderBy('unique_id', 'desc')->first();
        $nextNumber = 1;

        if ($lastBooking) {
            $lastNumber = (int) substr($lastBooking->unique_id, strlen($prefix));
            $nextNumber = $lastNumber + 1;
        }

        $newId = $prefix . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        if (!self::where('unique_id', $newId)->exists()) {
            return $newId;
        }

        throw new \Exception('Unable to generate a unique staff ID');
    }
}
