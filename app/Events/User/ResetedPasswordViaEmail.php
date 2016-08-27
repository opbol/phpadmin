<?php

namespace App\Events\User;

use App\User;

class ResetedPasswordViaEmail {
	/**
	 * @var User
	 */
	private $user;

	public function __construct(User $user) {
		$this->user = $user;
	}

	/**
	 * @return User
	 */
	public function getUser() {
		return $this->user;
	}
}
