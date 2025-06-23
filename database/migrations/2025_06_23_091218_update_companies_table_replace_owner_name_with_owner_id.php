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
        Schema::table('companies', function (Blueprint $table) {
            // Drop the owner_name column
            $table->dropColumn('owner_name');
            
            // Add owner_id foreign key
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            // Drop the foreign key and column
            $table->dropForeign(['owner_id']);
            $table->dropColumn('owner_id');
            
            // Add back owner_name column
            $table->string('owner_name');
        });
    }
};
