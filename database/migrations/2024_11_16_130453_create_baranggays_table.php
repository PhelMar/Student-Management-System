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
        Schema::create('baranggays', function (Blueprint $table) {
            $table->id();
            $table->string('brgy_code')->unique();
            $table->string('brgy_desc');
            $table->string('reg_code');
            $table->string('prov_code');
            $table->string('citymun_code');
            $table->timestamps();

            $table->foreign('citymun_code')->references('citymun_code')->on('municipalities')->onDelete('cascade');
            $table->foreign('prov_code')->references('prov_code')->on('provinces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baranggays');
    }
};
