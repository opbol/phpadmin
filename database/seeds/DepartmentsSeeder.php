<?php

use App\Department;
use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		$root = Department::create([
			'name' => '西安弈霆信息科技有限公司',
			'description' => '西安弈霆信息科技有限公司。',
            'parent_id' => 0,
			'sort' => 0,
		]);

        Department::create([
            'name' => '总经办',
            'description' => '总经办。',
            'sort' => 0,
        ], $root);

        Department::create([
            'name' => '技术部',
            'description' => '技术部。',
            'sort' => 10,
        ], $root);

        Department::create([
            'name' => '运营部',
            'description' => '运营部。',
            'sort' => 20,
        ], $root);

	}

}
