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
            $table->dropForeign(['course_id']);
            $table->dropForeign(['year_id']);
            $table->dropForeign(['semester_id']);
            $table->dropForeign(['school_year_id']);

            $table->dropColumn(['course_id', 'year_id', 'semester_id', 'school_year_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_students', function (Blueprint $table) {
            //
        });
    }
};
