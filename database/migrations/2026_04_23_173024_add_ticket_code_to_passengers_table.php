<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('passengers', function (Blueprint $table) {
            $table->string('ticket_code')->nullable()->unique()->after('nik');
            $table->boolean('is_validated')->default(false)->after('ticket_code');
            $table->timestamp('validated_at')->nullable()->after('is_validated');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('passengers', function (Blueprint $table) {
            $table->dropColumn(['ticket_code', 'is_validated', 'validated_at']);
        });
    }
};
