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
        Schema::create('ticket_category', function (Blueprint $table) {
            $table->id();
            $table->string('category_code')->nullable()->unique();
            $table->string('name');
            $table->unsignedBigInteger('office_id'); // Reference to the users table

            $table->foreign('office_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_category');
    }
};
