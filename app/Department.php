<?php

namespace App;

use Kalnoy\Nestedset\Node;

class Department extends Node {
	protected $table = 'departments';

	protected $fillable = ['name', 'sort', 'parent_id', 'description'];
    
}