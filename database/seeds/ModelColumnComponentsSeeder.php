<?php

use App\ModelColumnComponent;
use Illuminate\Database\Seeder;

class ModelColumnComponentsSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

        $template_text = <<<TPL
<div class="form-group">
    <label for="\$name">\$label</label>
    <input type="text" class="form-control" id="\$name" @name @value placeholder="\$label">
</div>
TPL;
        ModelColumnComponent::create([
			'name'          => '普通输入框',
			'template'      => $template_text,
			'support_types' => [ 'string', 'integer' ],
			'validators'    => [ 'required' ],
			'description'   => '普通输入框',
            'script'        => null,
			'removable'     => false,
            'status'        => 0,
		]);

        $template_select = <<<TPL
<div class="form-group">
    <label for="\$name">\$label</label>
    <select id="\$name" @name class="select2"></select>
</div>
TPL;
        ModelColumnComponent::create([
            'name'          => '下拉选择列表',
            'template'      => $template_select,
            'support_types' => [ 'string', 'integer' ],
            'validators'    => [ 'required' ],
            'description'   => '普通输入框',
            'script'        => null,
            'removable'     => false,
            'status'        => 0,
        ]);

        $template_date = <<<TPL
<div class="form-group">
    <label for="\$name">\$label</label>
    <div class="form-group">
        <div class="input-group date">
            <input type="text" id="\$name" @name value="\$value" class="form-control" />
            <span class="input-group-addon" style="cursor: default;">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    </div>
</div>
TPL;
        ModelColumnComponent::create([
            'name'          => '日期选择',
            'template'      => $template_date,
            'support_types' => [ 'date' ],
            'validators'    => [ 'required' ],
            'description'   => '日期选择输入框',
            'script'        => '$("#$name").datetimepicker({viewMode: "years", format: "YYYY-MM-DD"});',
            'removable'     => false,
            'status'        => 0,
        ]);

	}

}
