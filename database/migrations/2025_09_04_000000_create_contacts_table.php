<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('type'); // customer, vendor, other
            $table->string('category'); // legal, person
            $table->string('title')->nullable();  // شرکت، موسسه، آقای، خانم
            $table->string('name_firstname')->nullable();
            $table->string('brand_lastname')->nullable();
            $table->string('national_code')->unique()->nullable();

            $table->integer('creator_id')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};
