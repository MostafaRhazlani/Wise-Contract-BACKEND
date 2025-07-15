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
        if (!Schema::hasTable('companies')) {
            Schema::create('companies', function (Blueprint $table) {
                $table->id();
                $table->string('company_name');
                $table->string('email')->nullable();
                $table->text('address')->nullable();
                $table->string('company_logo')->nullable();
                $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
                $table->timestamps();
            });
        } else {
            // Add missing columns if table exists
            Schema::table('companies', function (Blueprint $table) {
                if (!Schema::hasColumn('companies', 'email')) {
                    $table->string('email')->nullable()->after('company_name');
                }
                if (!Schema::hasColumn('companies', 'address')) {
                    $table->text('address')->nullable()->after('email');
                }
                if (!Schema::hasColumn('companies', 'owner_id')) {
                    $table->foreignId('owner_id')->nullable()->constrained('users')->onDelete('cascade');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};