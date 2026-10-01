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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('purpose')->nullable();
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('notes')->nullable(); // Admin notes on approval/rejection
            $table->boolean('reminder_24h_sent')->default(false);
            $table->boolean('reminder_2h_sent')->default(false);
            $table->boolean('post_booking_sent')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->foreign('cancelled_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['cancelled_by']);
        });

        Schema::dropIfExists('bookings');
    }
};
