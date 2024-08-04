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
        return $this->hasMany(BookingDetails::class,'booking_id','id')->with('shift');
    }
    public function bookingAssigns()
    {
        return $this->hasMany(BookingAssign::class,'booking_id','id')->with('shift')->with('staff')->with('doctor');
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

        $lastBooking = self::where('unique_id', 'like', $prefix . '%')->orderBy('id', 'desc')->first();
        $nextNumber = 1;

        if ($lastBooking) {
            // Extract the numeric part of the inv_no if it matches the current year and booking ID
            if (strpos($lastBooking->unique_id, $prefix) === 0) {
                // Get the remaining part as the numeric count
                $latestInvNo = (int)substr($lastBooking->unique_id, strlen($prefix));
                $latestInvNo++; // Increment the count
            } else {
                // If the prefix does not match, start a new count
                $latestInvNo = 1;
            }
        } else {
            // No previous invoice, start with 1
            $latestInvNo = 1;
        }

        $newId = $prefix .  $latestInvNo;

        if (!self::where('unique_id', $newId)->exists()) {
            return $newId;
        }

        throw new \Exception('Unable to generate a unique booking ID');
    }
}
