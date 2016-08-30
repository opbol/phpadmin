<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelColumnComponent extends Model {

	protected $table = 'model_column_components';

    protected $casts = [
        'removable' => 'boolean',
        'support_types' => 'array',
        'validators' => 'array',
    ];

	protected $fillable = ['name', 'template', 'support_types', 'validators', 'description', 'removable', 'status'];
    
}