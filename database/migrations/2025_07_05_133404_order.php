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
        Schema::create("orders", function (Blueprint $table) {
            $table->id("order_id")->primary();
            $table->string("buyer_name");
            $table->integer("phone_number");
            $table->string("email");
            $table->unsignedBigInteger("trophy_id")->nullable();
            $table->boolean("isCustomize")->default(false);
            $table->unsignedBigInteger("customize_id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("orders");
    }
};
