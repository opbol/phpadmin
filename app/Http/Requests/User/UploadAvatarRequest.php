<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use App\User;

class UploadAvatarRequest extends Request {
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'file' => 'required|image',
		];
	}
}
