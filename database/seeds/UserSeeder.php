<?php

use App\Role;
use App\Support\Enum\UserStatus;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$user = User::create([
			'realname' => 'Admin',
			'email' => 'biyefeilan@qq.com',
			'username' => 'admin',
			'password' => 'admin',
			'avatar' => null,
			'country_id' => null,
			'department_id' => 1,
            'country_id' => 156,
			'status' => UserStatus::ACTIVE,
		]);

		$admin = Role::where('name', 'Admin')->first();

		$user->attachRole($admin);
		$user->socialNetworks()->create([]);
	}

}
