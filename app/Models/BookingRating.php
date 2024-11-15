<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingRating extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "booking_rating";

    public function created_by()
    {
        return $this->hasOne(User::class,'id','added_by');
    }
}
