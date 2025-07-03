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
        Schema::table('violations', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id')->change();

            $table->foreign('student_id')->references('id')->on('tbl_students')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('violations', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->bigInteger('student_id')->change();
        });
    }
};
