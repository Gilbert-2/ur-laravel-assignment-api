<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Individuals extends Model
{
    use HasFactory;
    protected $table = "individuals";
    protected $fillable = [
        "name",
        "address",
        "tel",
        "email"
    ];
}
