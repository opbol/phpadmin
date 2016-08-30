<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelColumnTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_column_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('command', 20)->unique();
            $table->text('args')->nullable();
            $table->boolean('nullable')->default(false);
            $table->string('default')->nullable();
            $table->text('description')->nullable();
            $table->boolean('removable')->default(true);
            $table->tinyInteger('status')->default(0);
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
        Schema::drop('model_column_types');
    }
}
