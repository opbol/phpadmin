<?php

namespace App\Events\User;

use App\User;

class Deleted {
	/**
	 * @var User
	 */
	protected $deletedUser;

	public function __construct(User $deletedUser) {
		$this->deletedUser = $deletedUser;
	}

	/**
	 * @return User
	 */
	public function getDeletedUser() {
		return $this->deletedUser;
	}
}
