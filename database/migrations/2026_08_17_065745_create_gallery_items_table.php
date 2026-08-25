<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_items', function (Blueprint $table) {

            $table->id();

            $table->foreignId('salon_id')
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Before / After
            |--------------------------------------------------------------------------
            */

            $table->string('before_image');

            $table->string('after_image');

            /*
            |--------------------------------------------------------------------------
            | Metadata
            |--------------------------------------------------------------------------
            */

            $table->string('title')
                ->nullable();

            $table->text('description')
                ->nullable();

            $table->string('alt_text')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Display
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Index
            |--------------------------------------------------------------------------
            */

            $table->index([
                'salon_id',
                'is_active',
                'sort_order',
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_items');
    }
};
