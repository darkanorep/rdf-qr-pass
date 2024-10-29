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
        Schema::create('attendees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->required();
            $table->string('first_name')->required();
            $table->string('last_name')->required();
            $table->string('contact')->required();
            $table->string('company')->required();
            $table->string('employee_id')->required();
            $table->string('position')->required();
            $table->string('department')->required();
            $table->string('unit')->required();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendees');
    }
};
