<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salon_daily_statuses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('salon_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->date('date');

            $table->enum('status', [
                'open',
                'closed',
            ])->default('open');

            $table->boolean('is_closed_today')->default(false);
            $table->date('closed_date')->nullable();
            $table->timestamps();

            $table->unique(['salon_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salon_daily_statuses');
    }
};
