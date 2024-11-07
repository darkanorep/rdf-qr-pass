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
        Schema::create('supplier_guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendee_response_id')->references('id')->on('attendee_responses');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_guests');
    }
};
