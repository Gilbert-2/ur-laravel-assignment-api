<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $table = "wallets";
    protected $fillable = [
        "balance",
        "user_id",
        "station_id",
        "created_by"
    ];
}
