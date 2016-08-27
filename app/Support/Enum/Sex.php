<?php

namespace App\Support\Enum;

class Sex {
	const MALE = '男';
    const FEMALE = '女';


	public static function lists() {
		return [
			self::MALE => trans('app.male'),
            self::FEMALE => trans('app.female'),
		];
	}
}