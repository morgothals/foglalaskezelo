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
        Schema::create('hairdresser_services', function (Blueprint $table) {
            $table->unsignedBigInteger('hairdresser_id');
            $table->unsignedBigInteger('service_id');
            $table->primary(['hairdresser_id', 'service_id']);

            $table->foreign('hairdresser_id')->references('hairdresser_id')->on('hairdressers')->onDelete('cascade');
            $table->foreign('service_id')->references('service_id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hairdresser_services');
    }
};
