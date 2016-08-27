<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
            $table->string('username')->unique();
			$table->string('email')->nullable()->unique();
            $table->string('phone')->nullable()->unique();
			$table->string('password');
			$table->string('realname')->nullable();
			$table->string('avatar')->nullable();
			$table->string('address')->default('');
            $table->unsignedInteger('department_id');
			$table->unsignedInteger('country_id')->nullable();
			$table->date('birthday')->nullable();
			$table->timestamp('last_login')->nullable();
			$table->string('confirmation_token', 60)->nullable();
			$table->string('status', 20);
			$table->integer('two_factor_country_code')->nullable();
			$table->integer('two_factor_phone')->nullable();
			$table->text('two_factor_options')->nullable();
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('users');
	}
}
