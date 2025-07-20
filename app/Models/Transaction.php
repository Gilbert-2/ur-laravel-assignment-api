<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = "transactions";
    protected $fillable = [
        "wallet_id",
        "amount",
        "station_id",
        "employee_id",
        "driver_id",
        "status",
        "created_by"
    ];
}
