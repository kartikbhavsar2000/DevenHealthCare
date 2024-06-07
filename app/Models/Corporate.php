<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Corporate extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "corporate";

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
}
