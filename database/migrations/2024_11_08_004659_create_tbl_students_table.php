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
        Schema::create('tbl_students', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_no')->unique();
            $table->string('first_name', 40);
            $table->string('middle_name', 40)->nullable();
            $table->string('last_name', 40);
            $table->string('nick_name', 40)->nullable();
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->date('birthdate');
            $table->integer('age')->nullable();
            $table->text('place_of_birth');
            $table->text('permanent_address');
            $table->text('current_address');
            $table->integer('birth_order_among_sibling');
            $table->string('contact_no', 11);
            $table->string('email_address')->unique();
            $table->string('facebook_account', 50);
            $table->unsignedBigInteger('dialect_id')->nullable();
            $table->foreign('dialect_id')->references('id')->on('dialects');
            $table->unsignedBigInteger('student_religion_id')->nullable();
            $table->foreign('student_religion_id')->references('id')->on('religions');
            $table->unsignedBigInteger('stay_id')->nullable();
            $table->foreign('stay_id')->references('id')->on('stays');
            $table->string('fathers_name', 90)->nullable();
            $table->date('fathers_birthdate')->nullable();
            $table->text('fathers_place_of_birth')->nullable();
            $table->text('fathers_address')->nullable();
            $table->string('fathers_contact_no', 11)->nullable();
            $table->unsignedBigInteger('fathers_highest_education_id')->nullable();
            $table->foreign('fathers_highest_education_id')->references('id')->on('highest_education');
            $table->string('fathers_occupation', 100)->nullable();
            $table->unsignedBigInteger('fathers_religion_id')->nullable();
            $table->foreign('fathers_religion_id')->references('id')->on('religions');
            $table->integer('number_of_fathers_sibling')->nullable();
            $table->string('mothers_name', 90)->nullable();
            $table->date('mothers_birthdate')->nullable();
            $table->text('mothers_place_of_birth')->nullable();
            $table->text('mothers_address')->nullable();
            $table->string('mothers_contact_no', 11)->nullable();
            $table->unsignedBigInteger('mothers_highest_education_id')->nullable();
            $table->foreign('mothers_highest_education_id')->references('id')->on('highest_education');
            $table->string('mothers_occupation', 100)->nullable();
            $table->unsignedBigInteger('mothers_religion_id')->nullable();
            $table->foreign('mothers_religion_id')->references('id')->on('religions');
            $table->integer('number_of_mothers_sibling')->nullable();
            $table->unsignedBigInteger('income_id')->nullable();
            $table->foreign('income_id')->references('id')->on('incomes');
            $table->unsignedBigInteger('parents_status_id')->nullable();
            $table->foreign('parents_status_id')->references('id')->on('parent_statuses');
            $table->string('incase_of_emergency_name', 100);
            $table->string('incase_of_emergency_contact', 11);
            $table->text('kindergarten')->nullable();
            $table->string('kindergarten_year_attended')->nullable();
            $table->text('elementary');
            $table->string('elementary_year_attended');
            $table->text('junior_high');
            $table->string('junior_high_year_attended');
            $table->text('senior_high')->nullable();
            $table->string('senior_high_year_attended')->nullable();
            $table->enum('pwd', ['No', 'Yes']);
            $table->string('pwd_remarks', 50)->nullable();
            $table->enum('ips', ['No', 'Yes']);
            $table->string('ips_remarks', 50)->nullable();
            $table->enum('solo_parent', ['No', 'Yes']);
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('courses');
            $table->unsignedBigInteger('year_id')->nullable();
            $table->foreign('year_id')->references('id')->on('years');
            $table->unsignedBigInteger('semester_id')->nullable();
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->unsignedBigInteger('school_year_id')->nullable();
            $table->foreign('school_year_id')->references('id')->on('school_years');
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_students');
    }
};
