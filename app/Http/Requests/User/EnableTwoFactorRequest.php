<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use App\User;

class EnableTwoFactorRequest extends Request {
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'country_code' => 'required|numeric|integer',
			'phone_number' => 'required|numeric',
		];
	}
}
