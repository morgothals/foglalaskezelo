<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // A price oszlop törlése, mert az árat innentől a pivot tábla tárolja
            $table->dropColumn('price');

            // name mező egyedivé tétele
            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // price visszaállítása eredeti formában
            $table->decimal('price', 10, 2);

            // unique index eltávolítása
            $table->dropUnique(['name']);
        });
    }
};
