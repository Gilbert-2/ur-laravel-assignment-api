<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("employees",function(Blueprint $table){
            $table->id();
            $table->string("employee_name");
            $table->string("address");
            $table->string("tel");
            $table->string("email");
            $table->string("national_id");
            $table->string("station_id");
            $table->string("status");
            $table->string("created_by");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
