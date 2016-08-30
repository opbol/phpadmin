<?php

use App\ModelColumnType;
use Illuminate\Database\Seeder;

class ModelColumnTypesSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		ModelColumnType::create([
			'name'          => '字符串',
			'command'       => 'string',
			'args'          => [
			    '0' => ['required' => false, 'type' => 'int', 'default' => 255, 'description' => '长度']
            ],
			'nullable'      => false,
			'default'       => null,
			'description'   => '相当于 VARCHAR 类型，长度可选',
			'removable'     => false,
            'status'        => 0,
		]);

        ModelColumnType::create([
            'name'          => '整形',
            'command'       => 'integer',
            'args'          => null,
            'nullable'      => false,
            'default'       => null,
            'description'   => '相当于 INTEGER 类型',
            'removable'     => false,
            'status'        => 0,
        ]);

        ModelColumnType::create([
            'name'          => '文本',
            'command'       => 'text',
            'args'          => null,
            'nullable'      => false,
            'default'       => null,
            'description'   => '相当于 TEXT 类型',
            'removable'     => false,
            'status'        => 0,
        ]);

        ModelColumnType::create([
            'name'          => '日期',
            'command'       => 'date',
            'args'          => null,
            'nullable'      => false,
            'default'       => null,
            'description'   => '相当于 DATE 类型',
            'removable'     => false,
            'status'        => 0,
        ]);

        ModelColumnType::create([
            'name'          => '时间戳',
            'command'       => 'timestamp',
            'args'          => null,
            'nullable'      => false,
            'default'       => null,
            'description'   => '相当于 TIMESTAMP 类型',
            'removable'     => false,
            'status'        => 0,
        ]);

        ModelColumnType::create([
            'name'          => 'DECIMAL',
            'command'       => 'decimal',
            'args'          => [
                '0' => ['required' => true, 'type' => 'int', 'default' => 10, 'description' => '基数长度'],
                '1' => ['required' => true, 'type' => 'int', 'default' => 2, 'description' => '精度长度'],
            ],
            'nullable'      => false,
            'default'       => null,
            'description'   => '相当于 DECIMAL 类型，并带有精度与基数',
            'removable'     => false,
            'status'        => 0,
        ]);

        ModelColumnType::create([
            'name'          => '浮点型',
            'command'       => 'double',
            'args'          => [
                '0' => ['required' => true, 'type' => 'int', 'default' => 10, 'description' => '基数长度'],
                '1' => ['required' => true, 'type' => 'int', 'default' => 2, 'description' => '精度长度'],
            ],
            'nullable'      => false,
            'default'       => null,
            'description'   => '相当于 DOUBLE 类型，并带有精度与基数',
            'removable'     => false,
            'status'        => 0,
        ]);
	}

}
