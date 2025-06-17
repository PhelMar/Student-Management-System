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

            $table->unsignedBigInteger('pwd_remarks_id')->nullable()->after('pwd');

            $table->foreign('pwd_remarks_id')
                ->references('id')
                ->on('pwd_remarks')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_students', function (Blueprint $table) {
            // Rollback: remove foreign key and column
            $table->dropForeign(['pwd_remarks_id']);
            $table->dropColumn('pwd_remarks_id');

            // Re-add the old column
            $table->string('pwd_remarks')->nullable();
        });
    }
};
