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
        Schema::table('orders', function (Blueprint $table) {
            // Change the 'phone_number' column to a string type
            // Specify a reasonable length, e.g., 20 or 255 depending on your needs
            $table->string('phone_number', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // In the down method, you might want to revert it to integer if necessary
            // However, be aware that this will fail if existing string data cannot be converted to integer.
            // For production, consider dropping and re-adding if a direct 'change' causes issues on rollback.
            // For development, this might suffice.
            $table->integer('phone_number')->change();
        });
    }
};