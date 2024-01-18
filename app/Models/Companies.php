<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
   use HasFactory;
    protected $table = "companies";
    protected $fillable = [
        "company_name",
        "address",
        "tel",
        "company_email",
        "rdb_certificate",
        "status",
        "created_by"
    ];
}
