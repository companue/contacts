<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_titles', function (Blueprint $table) {
            $table->id();
            $table->string('lang');
            $table->string('title')->unique();
            $table->string('official_title')->nullable();
            $table->integer('creator_id')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_titles');
    }
};
