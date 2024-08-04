<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Staff extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "staff";

    public function types()
    {
        return $this->hasOne(StaffType::class,'id','type');
    }
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
    public function documents()
    {
        return $this->hasMany(StaffDocuments::class,'staff_id','id');
    }
    protected static function booted()
    {
        parent::boot();

        static::creating(function ($staff) {
            $staff->staff_id = self::generateUniqueStaffId();
        });
    }
    private static function generateUniqueStaffId()
    {
        $year = date('Y');
        $prefix = 'DHCS' . $year;

        $lastStaff = self::where('staff_id', 'like', $prefix . '%')->orderBy('id', 'desc')->first();
        $nextNumber = 1;

        if ($lastStaff) {
            // Extract the numeric part of the inv_no if it matches the current year and booking ID
            if (strpos($lastStaff->staff_id, $prefix) === 0) {
                // Get the remaining part as the numeric count
                $latestInvNo = (int)substr($lastStaff->staff_id, strlen($prefix));
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

        if (!self::where('staff_id', $newId)->exists()) {
            return $newId;
        }

        throw new \Exception('Unable to generate a unique staff ID');
    }
}
