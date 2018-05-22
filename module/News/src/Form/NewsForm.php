<?php
namespace News\Form;

use Zend\Form\Form;
use Zend\Form\Element\Text;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Radio;
use Zend\Form\Element\Textarea;
use Zend\Form\Element\Select;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;

class NewsForm extends Form {
	public $action;

	function __construct(){
		parent::__construct();

		//Language
		$this->add([
			'name'=>'lang',
			'type'=>Radio::class,
			'options'=>[
				'label' => 'Ngôn ngữ',
				'value_options'=>[
					'en'=>'English',
					'vi'=>'VietNam'
				],		
				'label_attributes'=>[
                    'class'=>"col-sm-2"
                ],
			],

			'attributes'=>[
				'value' => 'vi'
			],

		]);

		$this->add([
			'name'=>'tieude',
			'type'=>'text',
			'options'=>[
				'label'=>'Tiêu đề',
				'label_attributes'=>[
                    'class'=>"col-sm-2"
                ],
			],

			'attributes'=>[
				'class'=>'form-control',
				'placeholder'=>'Nhập tiêu đề bài viết'
			],
		]);

		$this->add([
			'name'=>'tomtat',
			'type'=>'Textarea',
			'options'=>[
				'label'=>'Tóm tắt',
				'label_attributes'=>[
                    'class'=>"col-sm-2"
                ],
			],

			'attributes'=>[
				'class'=>'form-control',
				'placeholder'=>'Nhập tóm tắt'
			],
		]);

		$this->add([
			'name'=>'urlhinh',
			'type'=>'File',
			'options'=>[
				'label'=>'Chọn hình',
				'label_attributes'=>[
                    'class'=>"col-sm-2"
                ],
			],

			'attributes'=>[
				'class'=>'form-control',
				'multiple'=>true
			],
		]);

		$this->add([
			'name'=>'content',
			'type'=>'Textarea',
			'options'=>[
				'label'=>'Nội dung',
				'label_attributes'=>[
                    'class'=>"control-label col-sm-2"
                ],
			],

			'attributes'=>[
				'class'=>'form-control',
				'placeholder'=>'Nhập nội dung bài viết'
			],
		]);

		$this->add([
			'name'=>'idloai',
			'type'=>Select::class,
			'options'=>[
				'label'=>'Thể loại',
				'label_attributes'=>[
                    'class'=>"col-sm-2"
                ],
			],

			'attributes'=>[
				'class'=>'form-control'
			],
		]);

		$this->add([
			'name'=>'noibat',
			'type'=>Checkbox::class,
			'options'=>[
				'label'=>'Nổi bật',
				'label_attributes'=>[
                    'class'=>"col-sm-2"
                ],
			],

			'attributes'=>[
                'value'=> 1,
                'required'=>false
            ]
		]);

		$this->add([
			'name'=>'anhien',
			'type'=>Checkbox::class,
			'options'=>[
				'label'=>'Ẩn hiện',
				'label_attributes'=>[
                    'class'=>"col-sm-2"
                ],
			],

			'attributes'=>[
                'value'=> 1,
                'required'=>false
            ]
		]);

		$this->add([
                'type'=>'Submit',
                'name'=>'btnSubmit',
                'attributes'=>[
                    'class'=>'btn btn-primary',
                    'value'=>'Add'
                ]
        ]);

		$this->filterForm();
	}

	function filterForm(){
		$filter = new InputFilter();
		$this->setInputFilter($filter);

		$filter->add([
			'name'		=>'tieude',
			'required'	=>true,
			'validators'=>[
				[
					'name'=>"NotEmpty",
					'options'=>[
						'messages'=>[
							NotEmpty::IS_EMPTY=>"Bạn chưa điền tiêu đề"
						],

						'break_chain_on_failure'=>true,
					],
				],

				[
					'name'=>"StringLength",
					'options'=>[
						'min'=>5,
						'max'=>30,
						'messages'=>[
							StringLength::TOO_SHORT=>"Tiêu đề tối thiểu %min% ký tự",
							StringLength::TOO_LONG=>"Tiêu đề tối đa %max% ký tự"
						],
						'break_chain_on_failure'=>true,
					]

				]
			]
		]);

	$filter->add([
			'name'		=>'tomtat',
			'required'	=>true,
			'validators'=>[
				[
					'name'=>"NotEmpty",
					'options'=>[
						'messages'=>[
							NotEmpty::IS_EMPTY=>"Bạn chưa nhập tóm tắt"
						],

						'break_chain_on_failure'=>true,
					],
				],

				[
					'name'=>"StringLength",
					'options'=>[
						'min'=>5,
						'max'=>50,
						'messages'=>[
							StringLength::TOO_SHORT=>"Tiêu đề tối thiểu %min% ký tự",
							StringLength::TOO_LONG=>"Tiêu đề tối đa %max% ký tự"
						],
						'break_chain_on_failure'=>true,
					]

				]
			]
		]);

	$filter->add([
			'name'		=>'content',
			'required'	=>true,
			'validators'=>[
				[
					'name'=>"NotEmpty",
					'options'=>[
						'messages'=>[
							NotEmpty::IS_EMPTY=>"Bạn chưa nhập nội dung"
						],

						'break_chain_on_failure'=>true,
					],
				],

				[
					'name'=>"StringLength",
					'options'=>[
						'min'=>5,
						'max'=>1000,
						'messages'=>[
							StringLength::TOO_SHORT=>"Tiêu đề tối thiểu %min% ký tự",
							StringLength::TOO_LONG=>"Tiêu đề tối đa %max% ký tự"
						],
						'break_chain_on_failure'=>true,
					]

				]
			]
		]);
	}
}



?>