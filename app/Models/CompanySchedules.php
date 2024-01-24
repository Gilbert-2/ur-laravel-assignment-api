<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySchedules extends Model
{
    use HasFactory;
       protected $table = "company_schedules";
    protected $fillable = [
        "user_id",
        "status",
        'company_id',
        "created_by",
        "plate_number"
    ];
}
