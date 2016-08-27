<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use App\User;

class UpdateDetailsRequest extends Request {
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'birthday' => 'date',
			'role' => 'required|exists:roles,id',
		];
	}
}
