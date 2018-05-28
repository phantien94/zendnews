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

use Zend\Filter; 
use Zend\Validator\File\UploadFile as FileUpload;
use Zend\Validator\File\FilesSize;
use Zend\Validator\File\MimeType;

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
<<<<<<< HEAD
			'name'=>'TieuDe',
=======
			'name'=>'tieude',
>>>>>>> af9d8f8f41c870163dd2ebd2d19db89d4027516a
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
<<<<<<< HEAD
			'name'=>'TomTat',
=======
			'name'=>'tomtat',
>>>>>>> af9d8f8f41c870163dd2ebd2d19db89d4027516a
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
<<<<<<< HEAD
			'name'=>'urlHinh',
			'type'=>'File',
=======
			'name'=>'urlhinh',
			'type'=>'file',
>>>>>>> af9d8f8f41c870163dd2ebd2d19db89d4027516a
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
<<<<<<< HEAD
			'name'=>'Content',
=======
			'name'=>'content',
>>>>>>> af9d8f8f41c870163dd2ebd2d19db89d4027516a
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
<<<<<<< HEAD
			'name'=>'idLoai',
=======
			'name'=>'idloai',
>>>>>>> af9d8f8f41c870163dd2ebd2d19db89d4027516a
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
<<<<<<< HEAD
			'name'=>'NoiBat',
=======
			'name'=>'noibat',
>>>>>>> af9d8f8f41c870163dd2ebd2d19db89d4027516a
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
<<<<<<< HEAD
			'name'=>'AnHien',
=======
			'name'=>'anhien',
>>>>>>> af9d8f8f41c870163dd2ebd2d19db89d4027516a
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

		//TIEUDE
		$filter->add([
<<<<<<< HEAD
			'name'		=>'TieuDe',
=======
			'name'		=>'tieude',
>>>>>>> af9d8f8f41c870163dd2ebd2d19db89d4027516a
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
<<<<<<< HEAD
						'max'=>80,
=======
						'max'=>30,
>>>>>>> af9d8f8f41c870163dd2ebd2d19db89d4027516a
						'messages'=>[
							StringLength::TOO_SHORT=>"Tiêu đề tối thiểu %min% ký tự",
							StringLength::TOO_LONG=>"Tiêu đề tối đa %max% ký tự"
						],
						'break_chain_on_failure'=>true,
					]

				]
			]
		]);

		//TOMTAT
		$filter->add([
<<<<<<< HEAD
			'name'		=>'TomTat',
=======
			'name'		=>'tomtat',
>>>>>>> af9d8f8f41c870163dd2ebd2d19db89d4027516a
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
<<<<<<< HEAD
						'max'=>150,
						'messages'=>[
							StringLength::TOO_SHORT=>"Tóm tắt tối thiểu %min% ký tự",
							StringLength::TOO_LONG=>"Tóm tắt tối đa %max% ký tự"
=======
						'max'=>50,
						'messages'=>[
							StringLength::TOO_SHORT=>"Tiêu đề tối thiểu %min% ký tự",
							StringLength::TOO_LONG=>"Tiêu đề tối đa %max% ký tự"
>>>>>>> af9d8f8f41c870163dd2ebd2d19db89d4027516a
						],
						'break_chain_on_failure'=>true,
					]

				]
			]
		]);

		//CONTENT
		$filter->add([
<<<<<<< HEAD
			'name'		=>'Content',
=======
			'name'		=>'content',
>>>>>>> af9d8f8f41c870163dd2ebd2d19db89d4027516a
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
<<<<<<< HEAD
							StringLength::TOO_SHORT=>"Nội dung tối thiểu %min% ký tự",
							StringLength::TOO_LONG=>"Nội dung tối đa %max% ký tự"
=======
							StringLength::TOO_SHORT=>"Tiêu đề tối thiểu %min% ký tự",
							StringLength::TOO_LONG=>"Tiêu đề tối đa %max% ký tự"
>>>>>>> af9d8f8f41c870163dd2ebd2d19db89d4027516a
						],
						'break_chain_on_failure'=>true,
					]

				]
			]
		]);

		
		// $fileUpload = new FileUpload();
  //       $fileUpload->setMessages([
  //           FileUpload::NO_FILE => 'Vui lòng chọn file'
  //       ]);

  //       $size = new FilesSize(['min'=>100, 'max'=>102400]);//100bytes->10kb
  //       $size->setMessages([
  //           FilesSize::TOO_BIG => 'File bạn chọn quá lớn (%size%), yêu cầu <= %max%',
  //           FilesSize::TOO_SMALL=>'File bạn chọn quá bé  (%size%), yêu cầu >= %min%',
  //           FilesSize::NOT_READABLE => "File bạn chọn không thể đọc"
  //       ]);

  //       $mimeType  = new \Zend\Validator\File\MimeType('image/gif, image/png, image/jpeg');
  //       $mimeType->setMessages([
  //            \Zend\Validator\File\MimeType::FALSE_TYPE => 'Mimetype (%type%) không được phép. Chỉ cho phép chọn file hình'
  //       ]);

  //       // File Input
  //       $fileInput = new \Zend\InputFilter\FileInput('urlhinh');
  //       $fileInput->setRequired(true);

  //       $fileInput->getValidatorChain()
  //                   ->attach($fileUpload,true,3)
  //                   ->attach($size,true,2)
  //                   ->attach($mimeType,true,1);
        
       
  //       $filter->add($fileInput);
        
	}
}



?>