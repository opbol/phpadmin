<?php

namespace App;

use App\Support\Authorization\AuthorizationRoleTrait;
use Config;
use Illuminate\Database\Eloquent\Model;

class Role extends Model {
	use AuthorizationRoleTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table;

	protected $casts = [
		'removable' => 'boolean',
	];

	/**
	 * Creates a new instance of the model.
	 *
	 * @param array $attributes
	 */
	public function __construct(array $attributes = []) {
		parent::__construct($attributes);
		$this->table = Config::get('entrust.roles_table');
	}

	protected $fillable = ['name', 'display_name', 'description'];
}