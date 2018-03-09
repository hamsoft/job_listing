<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobPositions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        \Schema::create('job_positions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('company_id');
            $table->integer('manager_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamp('deadline');
            $table->integer('status')->default(1);
            $table->timestamps();


            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('manager_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        \Schema::table('job_positions', function (Blueprint $table) {
            //
        });
    }
}
