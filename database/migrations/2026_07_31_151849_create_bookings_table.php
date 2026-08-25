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
        Schema::create('bookings', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relations
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('salon_id')
                ->constrained('salons')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('service_id')
                ->constrained('services')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Reference
            |--------------------------------------------------------------------------
            */

            $table->string('reference_code')
                ->unique();


            /*
            |--------------------------------------------------------------------------
            | Customer
            |--------------------------------------------------------------------------
            */

            $table->string('customer_name');

            $table->string('customer_phone');


            /*
            |--------------------------------------------------------------------------
            | Booking Date / Time
            |--------------------------------------------------------------------------
            */

            $table->date('booking_date');

            $table->time('booking_time');


            /*
            |--------------------------------------------------------------------------
            | Notes
            |--------------------------------------------------------------------------
            */

            $table->text('customer_note')
                ->nullable();

            $table->text('barber_note')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Financial / Duration
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('final_price')
                ->nullable();

            $table->unsignedInteger('duration_minutes')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'approved',
                'completed',
                'rejected',
                'cancelled',
            ])->default('pending');

            $table->timestamp('approved_at')
                ->nullable();

            $table->timestamp('completed_at')
                ->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
