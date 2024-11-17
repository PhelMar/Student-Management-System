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
        Schema::create('municipalities', function (Blueprint $table) {
            $table->id();
            $table->string('psgc_code')->unique();
            $table->string('citymun_desc');
            $table->string('reg_desc');
            $table->string('prov_code');
            $table->string('citymun_code')->unique();
            $table->timestamps();
        
            $table->foreign('prov_code')->references('prov_code')->on('provinces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('municipalities');
    }
};
