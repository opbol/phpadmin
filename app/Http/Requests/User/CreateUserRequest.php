<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use App\User;

class CreateUserRequest extends Request {
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'email' => 'email|unique:users,email',
            'phone' => 'regex:/^1\d{10}$/|unique:users,phone',
			'username' => 'required|unique:users,username',
            'realname' => 'required',
			'password' => 'required|min:6|confirmed',
			'birthday' => 'date',
			'role' => 'required|exists:roles,id',
			'department_id' => 'required|exists:departments,id',
		];
	}
}
