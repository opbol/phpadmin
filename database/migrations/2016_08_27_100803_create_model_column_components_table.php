<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelColumnComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_column_components', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->text('template')->nullable();
            $table->text('support_types')->nullable();
            $table->text('validators')->nullable();
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
        Schema::drop('model_column_components');
    }
}
