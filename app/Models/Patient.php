<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Patient extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "patient";

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

        static::creating(function ($patient) {
            $patient->patient_id = self::generateUniquePatientId();
        });
    }
    private static function generateUniquePatientId()
    {
        $year = date('Y');
        $prefix = 'DHCP' . $year;

        $lastPatient = self::where('patient_id', 'like', $prefix . '%')->orderBy('patient_id', 'desc')->first();
        $nextNumber = 1;

        if ($lastPatient) {
            $lastNumber = (int) substr($lastPatient->patient_id, strlen($prefix));
            $nextNumber = $lastNumber + 1;
        }

        $newId = $prefix . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        if (!self::where('patient_id', $newId)->exists()) {
            return $newId;
        }

        throw new \Exception('Unable to generate a unique staff ID');
    }
}
