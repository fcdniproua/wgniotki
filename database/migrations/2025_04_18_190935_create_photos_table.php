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
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained();
            $table->foreignId('service_id')->constrained();
            $table->integer('slider_1');
            $table->integer('slider_2');
            $table->string('slider_tag');
            $table->integer('is_gallery')->default(0);
            $table->string('path');
            $table->string('original_name');
            $table->unsignedInteger('size');
            $table->string('mime_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
