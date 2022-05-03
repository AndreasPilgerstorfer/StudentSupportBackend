<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade'); // FK
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // FK
            $table->foreignId('image_id')->constrained()->onDelete('cascade'); // FK

            $table->string("start_time");
            $table->string("end_time");
            $table->date("date");
            $table->string("title");
            $table->text("description");
            $table->string("state");
            $table->string("associatedStudent");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
