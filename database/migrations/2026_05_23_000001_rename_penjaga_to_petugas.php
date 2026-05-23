<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update existing user role values
        DB::table('users')->where('role', 'penjaga')->update(['role' => 'petugas']);

        // Modify enum column to include 'petugas'
        DB::statement("ALTER TABLE users MODIFY role ENUM('super_admin','admin','petugas','user') NOT NULL DEFAULT 'user'");
    }

    public function down(): void
    {
        DB::table('users')->where('role', 'petugas')->update(['role' => 'penjaga']);
        DB::statement("ALTER TABLE users MODIFY role ENUM('super_admin','admin','penjaga','user') NOT NULL DEFAULT 'user'");
    }
};
