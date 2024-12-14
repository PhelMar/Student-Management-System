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
        Schema::table('tbl_students', function (Blueprint $table) {
            $table->enum('four_ps', ['No', 'Yes']);
            $table->enum('scholarship', ['No', 'Yes']);
            $table->string('scholarship_remarks', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_students', function (Blueprint $table) {
            $table->dropColumn(['four_ps', 'scholarship', 'scholarship_remarks']);
        });
    }
};
