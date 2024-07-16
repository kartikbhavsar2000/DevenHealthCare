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

        $lastDoctor = self::where('doctor_id', 'like', $prefix . '%')->orderBy('doctor_id', 'desc')->first();
        $nextNumber = 1;

        if ($lastDoctor) {
            $lastNumber = (int) substr($lastDoctor->doctor_id, strlen($prefix));
            $nextNumber = $lastNumber + 1;
        }

        $newId = $prefix . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        if (!self::where('doctor_id', $newId)->exists()) {
            return $newId;
        }

        throw new \Exception('Unable to generate a unique doctor ID');
    }
}
