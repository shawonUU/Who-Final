<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFinishedModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_finished_modules', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            // $table->string('user_type')->nullable();
            // $table->integer('course_id')->nullable();
            $table->integer('module_id')->nullable();
            $table->tinyInteger('submit_status')->default(1);
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
        Schema::dropIfExists('user_finished_modules');
    }
}
