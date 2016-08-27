<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class PasswordResetRequest extends Request {
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'token' => 'required',
			'email' => 'required|email',
			'password' => 'required|confirmed|min:6',
		];
	}
}
