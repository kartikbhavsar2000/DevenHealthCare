<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = "doctor";

    public function state()
    {
        return $this->hasOne(State::class,'id','state');
    }
    public function city()
    {
        return $this->hasOne(City::class,'id','city');
    }
    public function area()
    {
        return $this->hasOne(Area::class,'id','area');
    }
    protected static function booted()
    {
        parent::boot();

        static::creating(function ($doctor) {
            $doctor->doctor_id = self::generateUniqueDoctorId();
        });
    }
    private static function generateUniqueDoctorId()
    {
        $year = date('Y');
        $prefix = 'DHCD' . $year;

        $lastDoctor = self::where('doctor_id', 'like', $prefix . '%')->orderBy('id', 'desc')->first();
        $nextNumber = 1;

        if ($lastDoctor) {
            // Extract the numeric part of the inv_no if it matches the current year and booking ID
            if (strpos($lastDoctor->doctor_id, $prefix) === 0) {
                // Get the remaining part as the numeric count
                $latestInvNo = (int)substr($lastDoctor->doctor_id, strlen($prefix));
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

        if (!self::where('doctor_id', $newId)->exists()) {
            return $newId;
        }

        throw new \Exception('Unable to generate a unique doctor ID');
    }
}
