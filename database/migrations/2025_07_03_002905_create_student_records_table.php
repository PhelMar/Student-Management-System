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
        Schema::create('student_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('year_id')->nullable();
            $table->unsignedBigInteger('semester_id')->nullable();
            $table->unsignedBigInteger('school_year_id')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('tbl_students')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('year_id')->references('id')->on('years');
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->foreign('school_year_id')->references('id')->on('school_years');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_records');
    }
};
