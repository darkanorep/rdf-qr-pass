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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->required();
            $table->string('company')->required();
            $table->string('employee_id')->required();
            $table->string('first_name')->required();
            $table->string('last_name')->nullable();
            $table->string('department')->required();
            $table->string('unit')->nullable();
            $table->string('position')->nullable();
            $table->string('username')->required();
            $table->string('password')->required();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
