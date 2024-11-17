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
            // Drop columns that are no longer needed
            $table->dropColumn(['current_address', 'permanent_address']);
            $table->dropColumn(['fathers_address', 'mothers_address']);

            // Add the correct foreign key columns (change to 'string' type if needed)
            $table->string('current_province_id')->after('place_of_birth');
            $table->string('current_municipality_id')->after('current_province_id');
            $table->string('current_barangay_id')->after('current_municipality_id');
            $table->string('current_purok', 100)->nullable()->after('current_barangay_id');

            // Permanent address columns
            $table->string('permanent_province_id')->after('current_purok');
            $table->string('permanent_municipality_id')->after('permanent_province_id');
            $table->string('permanent_barangay_id')->after('permanent_municipality_id');
            $table->string('permanent_purok', 100)->nullable()->after('permanent_barangay_id');

            // Fathers' address columns
            $table->string('fathers_province_id')->nullable()->after('fathers_place_of_birth');
            $table->string('fathers_municipality_id')->nullable()->after('fathers_province_id');
            $table->string('fathers_barangay_id')->nullable()->after('fathers_municipality_id');
            $table->string('fathers_purok', 100)->nullable()->after('fathers_barangay_id');

            // Mothers' address columns
            $table->string('mothers_province_id')->nullable()->after('mothers_place_of_birth');
            $table->string('mothers_municipality_id')->nullable()->after('mothers_province_id');
            $table->string('mothers_barangay_id')->nullable()->after('mothers_municipality_id');
            $table->string('mothers_purok', 100)->nullable()->after('mothers_barangay_id');

            // Define foreign key relationships
            $table->foreign('current_province_id')->references('prov_code')->on('provinces')->onDelete('cascade');
            $table->foreign('current_municipality_id')->references('citymun_code')->on('municipalities')->onDelete('cascade');
            $table->foreign('current_barangay_id')->references('brgy_code')->on('baranggays')->onDelete('cascade');

            $table->foreign('permanent_province_id')->references('prov_code')->on('provinces')->onDelete('cascade');
            $table->foreign('permanent_municipality_id')->references('citymun_code')->on('municipalities')->onDelete('cascade');
            $table->foreign('permanent_barangay_id')->references('brgy_code')->on('baranggays')->onDelete('cascade');

            $table->foreign('fathers_province_id')->references('prov_code')->on('provinces')->onDelete('cascade');
            $table->foreign('fathers_municipality_id')->references('citymun_code')->on('municipalities')->onDelete('cascade');
            $table->foreign('fathers_barangay_id')->references('brgy_code')->on('baranggays')->onDelete('cascade');

            $table->foreign('mothers_province_id')->references('prov_code')->on('provinces')->onDelete('cascade');
            $table->foreign('mothers_municipality_id')->references('citymun_code')->on('municipalities')->onDelete('cascade');
            $table->foreign('mothers_barangay_id')->references('brgy_code')->on('baranggays')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_students', function (Blueprint $table) {

            $table->text('current_address')->nullable();
            $table->text('permanent_address')->nullable();

            $table->dropForeign(['province_id']);
            $table->dropForeign(['municipality_id']);
            $table->dropForeign(['barangay_id']);
            $table->dropColumn(['province_id', 'municipality_id', 'barangay_id', 'purok']);

            $table->text('fathers_address')->nullable();
            $table->text('mothers_address')->nullable();

            $table->dropForeign(['fathers_province_id'])->nullable();
            $table->dropForeign(['fathers_municipality_id'])->nullable();
            $table->dropForeign(['fathers_barangay_id'])->nullable();
            $table->dropForeign(['mothers_province_id'])->nullable();
            $table->dropForeign(['mothers_municipality_id'])->nullable();
            $table->dropForeign(['mothers_barangay_id'])->nullable();

            $table->dropColumn([
                'fathers_province_id',
                'fathers_municipality_id',
                'fathers_barangay_id',
                'fathers_purok',
                'mothers_province_id',
                'mothers_municipality_id',
                'mothers_barangay_id',
                'mothers_purok'
            ]);
        });
    }
};
