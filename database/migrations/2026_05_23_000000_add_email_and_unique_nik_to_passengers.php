<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('passengers', function (Blueprint $table) {
            if (! Schema::hasColumn('passengers', 'email')) {
                $table->string('email')->nullable()->after('nik');
            }

        });
    }

    public function down(): void
    {
        Schema::table('passengers', function (Blueprint $table) {
            if (Schema::hasColumn('passengers', 'email')) {
                $table->dropColumn('email');
            }

            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = array_map(fn ($i) => $i->getName(), $sm->listTableIndexes('passengers'));
            if (in_array('passengers_nik_unique', $indexes)) {
                $table->dropUnique('passengers_nik_unique');
            }
        });
    }
};
