<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use App\User;

class UpdateLoginDetailsRequest extends Request {
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		$user = $this->getUserForUpdate();

		return [
			'email' => 'email|unique:users,email,' . $user->id,
            'phone' => 'regex:/^1\d{10}$/|unique:users,phone,' . $user->id,
			'username' => 'required|unique:users,username,' . $user->id,
			'password' => 'min:6|confirmed',
		];
	}

	/**
	 * @return \Illuminate\Routing\Route|object|string
	 */
	protected function getUserForUpdate() {
		return $this->route('user');
	}
}
