<?php
namespace News\Form;

use Zend\Form\Form;
use Zend\Form\Element\Text;
use Zend\Validator\NotEmpty;

class SearchForm extends Form{
	public $key;

	function __construct(){
		parent::__construct();
		
		$this->add([
			'name'=>'TuKhoa',
			'type'=>'text',
			'options'=>[
				'label'=>'Từ khóa',
				'label_attributes'=>[
                    'class'=>"control-label col-sm-2"
                ],
			],

			'attributes'=>[
				'class'=>'form-control',
				'placeholder'=>'Nhập từ khóa'
			],
		]);

		$this->add([
                'type'=>'Submit',
                'name'=>'btnSubmit',
                'attributes'=>[
                    'class'=>'btn btn-primary',
                    'value'=>'Tìm kiếm'
                ]
            ]);
	}
}

?>