<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StationSchedules extends Model
{
    use HasFactory;
    protected $table = "station_schedules";
    protected $fillable = [
        "user_id",
        "status",
        'station_id',
        "created_by"
    ];
}
