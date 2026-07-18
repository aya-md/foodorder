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
    Schema::table('users', function (Blueprint $table) {
        $table->foreignId('business_id')->nullable()->after('id')->constrained()->nullOnDelete();
        $table->enum('role', ['super_admin', 'owner', 'staff'])->default('owner')->after('business_id');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['business_id']);
        $table->dropColumn(['business_id', 'role']);
    });
}
};
