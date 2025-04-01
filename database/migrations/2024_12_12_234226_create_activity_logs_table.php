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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('log_code')->nullable()->unique();
            $table->string('type')->nullable(); // e.g., 'login', 'logout', 'ticket', 'signup'
            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->text('description'); // The log message
            $table->unsignedBigInteger('user_id')->nullable(); // Who performed the action
            $table->string('user_type')->nullable(); // Polymorphic relation (in case of different user models)
            $table->json('additional_data')->nullable(); // For any extra context
            $table->ipAddress('ip_address')->nullable(); // IP address of the action
            $table->timestamps();

            // Optional foreign key constraint
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('ticket_id')
                ->references('id')
                ->on('tickets')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
