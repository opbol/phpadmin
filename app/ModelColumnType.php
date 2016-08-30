<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelColumnType extends Model {

	protected $table = 'model_column_types';

    protected $casts = [
        'args'      => 'array',
        'nullable'  => 'boolean',
        'removable' => 'boolean',
    ];

	protected $fillable = ['name', 'command', 'args', 'nullable', 'default', 'description', 'removable', 'status'];
    
}