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
        Schema::create('data_bank', function (Blueprint $table) {
            $table->id();
            $table->string('data_code')->nullable()->unique();
            $table->foreignId('author_id')->nullable()->constrained('users')->onDelete('cascade'); // Foreign key to users table
            $table->string('chatPattern');
            $table->text('chatResponse');
            $table->integer('likes')->nullable();
            $table->integer('dislikes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_bank');
    }
};
