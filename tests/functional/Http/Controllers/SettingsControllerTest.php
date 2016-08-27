<?php

class SettingsControllerTest extends FunctionalTestCase {
	public function test_update_app_name() {
		$user = $this->createSuperUser();
		$this->be($user);

		$oldName = Settings::get('app_name', 'TaxManage');

		Settings::set('app_name', 'bar');

		$name = 'foo';

		$this->visit('dashboard/settings')
			->seeInField('app_name', 'bar')
			->type('foo', 'app_name')
			->press('Update Settings');

		$this->assertEquals($name, Settings::get('app_name'));

		$this->visit('logout')
			->seeInElement("title", $name);

		Settings::set('app_name', $oldName);
		Settings::save();
	}
}
