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
        Schema::table('anggotas', function (Blueprint $table) {
            $table->string('business_sector', 100)->nullable()->after('job_address');
            $table->string('business_type', 100)->nullable()->after('business_sector');
            $table->string('business_interest', 100)->nullable()->after('business_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anggotas', function (Blueprint $table) {
            $table->dropColumn(['business_sector', 'business_type', 'business_interest']);
        });
    }
};
