<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('candidates', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('job_position_id');
            $table->boolean('accepted')->default(0);
            $table->string('name');
            $table->string('email');
            $table->string('phone_number');
            $table->text('cover_letter')->nullalbe();
            $table->string('cv')->nullable();
            $table->timestamps();

            $table->foreign('job_position_id')->references('id')->on('job_positions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('candidates', function (Blueprint $table) {
            //
        });
    }
}
