<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$adminRole = Role::where('name', 'Admin')->first();

		$permissions[] = Permission::create([
			'name' => 'departments.manage',
			'display_name' => '部门管理',
			'description' => '管理组织机构。',
			'removable' => false,
		]);

		$permissions[] = Permission::create([
			'name' => 'users.manage',
			'display_name' => '用户管理',
			'description' => '管理用户和用户会话。',
			'removable' => false,
		]);

		$permissions[] = Permission::create([
			'name' => 'users.activity',
			'display_name' => '日志查看',
			'description' => '查看所有用户的系统日志。',
			'removable' => false,
		]);

		$permissions[] = Permission::create([
			'name' => 'roles.manage',
			'display_name' => '角色管理',
			'description' => '管理系统角色。',
			'removable' => false,
		]);

		$permissions[] = Permission::create([
			'name' => 'permissions.manage',
			'display_name' => '权限管理',
			'description' => '管理系统角色权限',
			'removable' => false,
		]);

        $permissions[] = Permission::create([
            'name' => 'backups.manage',
            'display_name' => '数据备份',
            'description' => '管理数据库备份。',
            'removable' => false,
        ]);

		$permissions[] = Permission::create([
			'name' => 'settings.general',
			'display_name' => '常规设置',
			'description' => '系统常规设置',
			'removable' => false,
		]);

//		$permissions[] = Permission::create([
//			'name' => 'settings.auth',
//			'display_name' => '认证设置',
//			'description' => '系统登录和注册设置。',
//			'removable' => false,
//		]);
//
//		$permissions[] = Permission::create([
//			'name' => 'settings.notifications',
//			'display_name' => '通知设置',
//			'description' => '系统通知设置。',
//			'removable' => false,
//		]);

		$adminRole->attachPermissions($permissions);
	}

}
