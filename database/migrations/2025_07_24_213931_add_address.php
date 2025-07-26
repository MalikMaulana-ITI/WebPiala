<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('shipping_address')->nullable();
            $table->string('village_name')->nullable();
            $table->string('district_name')->nullable();
            $table->string('regency_name')->nullable();
            $table->string('province_name')->nullable(); 
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('shipping_address');
            $table->dropColumn('village_name');
            $table->dropColumn('district_name');
            $table->dropColumn('regency_name');
            $table->dropColumn('province_name'); 
        });
    }
};
