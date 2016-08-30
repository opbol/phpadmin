<?php

namespace App\Events\ModelColumnType;

use App\ModelColumnType;

abstract class ModelColumnTypeEvent {
	/**
	 * @var ModelColumnType
	 */
	protected $modelColumnType;

	public function __construct(ModelColumnType $modelColumnType) {
		$this->modelColumnType = $modelColumnType;
	}

	/**
	 * @return ModelColumnType
	 */
	public function getModelColumnType() {
		return $this->modelColumnType;
	}
}