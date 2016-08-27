<?php

namespace App\Events\User;

use App\User;

class Created {
	/**
	 * @var User
	 */
	protected $createdUser;

	public function __construct(User $createdUser) {
		$this->createdUser = $createdUser;
	}

	/**
	 * @return User
	 */
	public function getCreatedUser() {
		return $this->createdUser;
	}
}
