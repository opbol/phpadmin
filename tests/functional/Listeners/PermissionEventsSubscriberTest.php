<?php

use App\Events\Permission\Created;
use App\Events\Permission\Deleted;
use App\Events\Permission\Updated;

class PermissionEventsSubscriberTest extends BaseListenerTestCase {
	protected $perm;

	public function setUp() {
		parent::setUp();
		$this->perm = factory(\App\Permission::class)->create();
	}

	public function test_onCreate() {
		event(new Created($this->perm));
		$this->assertMessageLogged("Created new permission called {$this->perm->display_name}.");
	}

	public function test_onUpdate() {
		event(new Updated($this->perm));
		$this->assertMessageLogged("Updated the permission named {$this->perm->display_name}.");
	}

	public function test_onDelete() {
		event(new Deleted($this->perm));
		$this->assertMessageLogged("Deleted permission named {$this->perm->display_name}.");
	}

}
