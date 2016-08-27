<?php

namespace App\Presenters;

use App\Support\Enum\UserStatus;
use Illuminate\Support\Str;
use Laracodes\Presenter\Presenter;

class UserPresenter extends Presenter {
	public function name() {
		return sprintf("%s", $this->model->realname);
	}

	public function nameOrEmail() {
		return trim($this->name()) ?: $this->model->email;
	}

	public function avatar() {
		if (!$this->model->avatar) {
			return url('assets/img/profile.png');
		}

		return Str::contains($this->model->avatar, ['http', 'gravatar'])
		? $this->model->avatar
		: url("upload/users/{$this->model->avatar}");
	}

	public function birthday() {
		return $this->model->birthday
		? $this->model->birthday->toDateString()
		: '-';
	}

	public function fullAddress() {
		$address = '';
		$user = $this->model;

		if ($user->address) {
			$address .= $user->address;
		}

		if ($user->country_id) {
			$address .= $user->address ? ", {$user->country->name}" : $user->country->name;
		}

		return $address ?: '-';
	}

	public function lastLogin() {
		return $this->model->last_login
		? $this->model->last_login->diffForHumans()
		: '-';
	}

	/**
	 * Determine css class used for status labels
	 * inside the users table by checking user status.
	 *
	 * @return string
	 */
	public function labelClass() {
		switch ($this->model->status) {
		case UserStatus::ACTIVE:
			$class = 'success';
			break;

		case UserStatus::BANNED:
			$class = 'danger';
			break;

		default:
			$class = 'warning';
		}

		return $class;
	}
}