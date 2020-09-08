<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->date('date_schedule');
            $table->enum('status', ['aberto', 'fechado']);
            $table->timestamps();

            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreignId('call_id')
                ->references('id')
                ->on('calls')
                ->cascadeOnDelete();

            $table->foreignId('team_id')
                ->references('id')
                ->on('teams')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
