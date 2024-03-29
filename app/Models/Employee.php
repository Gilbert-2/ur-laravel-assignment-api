<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = "employees";
    protected $fillable = [
        "employee_name",
        "address",
        "tel",
        "email",
        "national_id",
        "station_id",
        "status",
        "created_by"
    ];
}
