<?php

namespace App\Repositories\Country;

use App\Country;

class EloquentCountry implements CountryRepository {
	/**
	 * {@inheritdoc}
	 */
	public function lists($column = 'name', $key = 'id') {
		return Country::orderBy('name')->lists($column, $key);
	}
}