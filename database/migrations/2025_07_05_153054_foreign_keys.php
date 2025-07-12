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
        Schema::table("trophies", function (Blueprint $table) {
            $table->index("material_id");
            $table->foreign("material_id")->references("id")->on("trophy_materials")->onDelete("cascade")->onUpdate("cascade");
        });
        
        Schema::table("orders", function (Blueprint $table) {
            $table->index("trophy_id");
            $table->index("customize_id");
            $table->foreign("customize_id")->references("id")->on("customize_trophies")->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("trophy_id")->references("id")->on("trophies")->onUpdate("cascade")->onDelete("cascade");
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trophies', function (Blueprint $table) {
            $table->dropForeign(['material_id']); 
            $table->dropIndex(['material_id']); 
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['customize_id']);
            $table->dropForeign(['trophy_id']);
            $table->dropIndex(['customize_id']);
            $table->dropIndex(['trophy_id']);
        });
    }
};
