<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qrcode extends Model
{
  use HasFactory;
    protected $table = "qrcodes";
    protected $fillable = [
        "qrcode",
        "status",
        "plate_number",
        "driver_id",
        "user_id",
        'station_id',
        "amount",
        "created_by"
    ];
}
