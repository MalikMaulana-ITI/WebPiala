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
        Schema::create("trophy_materials", function (Blueprint $table) {
            $table->id()->primary();
            $table->string("material_name");
            $table->float("price");
            $table->timestamps();
            
        });

       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("trophy_materials");
    }
};
