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
        Schema::create('tbl_organizations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_id');
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->unsignedBigInteger('year_id');
            $table->foreign('year_id')->references('id')->on('years');
            $table->unsignedBigInteger('semester_id');
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->unsignedBigInteger('school_year_id');
            $table->foreign('school_year_id')->references('id')->on('school_years');
            $table->unsignedBigInteger('organization_types_id');      
            $table->unsignedBigInteger('positions_id');      
            $table->date('organization_date');
            $table->timestamps();

            $table->foreign('student_id')->references('id_no')->on('tbl_students')->onDelete('cascade');
            $table->foreign('organization_types_id')->references('id')->on('organization_types');
            $table->foreign('positions_id')->references('id')->on('positions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_organizations');
    }
};
