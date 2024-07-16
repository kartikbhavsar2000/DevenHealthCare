<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdvanceSalaryHistory extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = "advance_salary_history";

    public function staff()
    {
        return $this->hasOne(Staff::class,'id','staff_id');
    }
    public function created_by_user()
    {
        return $this->hasOne(User::class,'id','added_by');
    }
}
