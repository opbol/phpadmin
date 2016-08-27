<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		Role::create([
			'name' => 'Admin',
			'display_name' => '系统管理员',
			'description' => "系统管理员。",
			'removable' => false,
		]);
        
		Role::create([
			'name' => 'User',
			'display_name' => '普通用户',
			'description' => '默认的系统普通用户。',
			'removable' => false,
		]);

	}

}
