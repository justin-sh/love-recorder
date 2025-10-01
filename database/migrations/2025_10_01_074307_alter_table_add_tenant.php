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
        Schema::table('children',function (Blueprint $table){
            $table->unsignedBigInteger('tenant_id')->nullable()->after('weight_dob');
        });
        Schema::table('events',function (Blueprint $table){
            $table->unsignedBigInteger('tenant_id')->nullable()->after('note');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('children',function (Blueprint $table){
            $table->dropColumn('tenant_id');
        });
        Schema::table('events',function (Blueprint $table){
            $table->dropColumn('tenant_id');
        });
    }
};
