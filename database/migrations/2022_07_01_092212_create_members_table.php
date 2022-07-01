<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('memberId');
            $table->timestamps();
            $table->date('birthDate');
            $table->string('firstName', 30);
            $table->string('lastName', 30);
            $table->string('subject', 255);
            $table->string('country', 255);
            $table->string('email', 30)->unique();
            $table->string('phone', 30);
            $table->string('position', 255)->nullable();
            $table->string('company', 255)->nullable();
            $table->text('about')->nullable();
            $table->string('photo', 255)->default('images/default-image.png');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
};
