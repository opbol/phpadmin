<?php

use App\Events\Role\Created;
use App\Events\Role\Deleted;
use App\Events\Role\PermissionsUpdated;
use App\Events\Role\Updated;

class RoleEventsSubscriberTest extends BaseListenerTestCase {
	protected $role;

	public function setUp() {
		parent::setUp();
		$this->role = factory(\App\Role::class)->create();
	}

	public function test_onCreate() {
		event(new Created($this->role));
		$this->assertMessageLogged("Created new role called {$this->role->display_name}.");
	}

	public function test_onUpdate() {
		event(new Updated($this->role));
		$this->assertMessageLogged("Updated role with name {$this->role->display_name}.");
	}

	public function test_onDelete() {
		event(new Deleted($this->role));
		$this->assertMessageLogged("Deleted role named {$this->role->display_name}.");
	}

	public function test_onPermissionsUpdate() {
		event(new PermissionsUpdated($this->role));
		$this->assertMessageLogged("Updated role permissions.");
	}

}
