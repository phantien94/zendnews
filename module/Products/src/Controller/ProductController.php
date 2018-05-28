<?php
namespace Products\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Products\Model\ProductsTable;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;
use Products\Form\ProductForm;
use Zend\Filter\File\Rename;
use Products\Model\Products;
use Zend\Mvc\Plugin\FlashMessenger;


class ProductController extends AbstractActionController{

	public $table;
	function __construct(ProductsTable $table){
		$this->table = $table;
	}

	function testDBAction(){
		echo $this->table->testConnect();
		$result = $this->table->getAllProducts();

		foreach ($result as $product) {
			echo "<pre>";
			print_r($product);
			echo "</pre>";
		}
		return false;	
	}

	function indexAction(){
		 //    $products = $this->table->getAllProducts();
        $page = $this->params()->fromRoute('page');
        
        $products = $this->table->fetchAll();
        $arrProducts = [];
        foreach($products as $p){
            $arrProducts[] = $p; 
        }
        $paginator = new Paginator(new ArrayAdapter($arrProducts));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(5);
        $paginator->setPageRange(3);
        return new ViewModel(['products'=>$paginator]);

	}

	function addAction(){
		$form = new ProductForm();

		//Lấy loại cho product
		$types = $this->table->getAllType();
		$arrType = [];
		foreach($types as $type){
			$arrType[$type['id']] = $type['name'];
		}
		// print_r($arrType);
		// return false;
		$form->get('id_type')->setValueOptions($arrType); //Dùng setValueOption để gán loại sp cho add.phtml

		$request = $this->getRequest();

		if($request->isGet()){
			return new ViewModel(['form'=>$form]);
		}

		//Lưu vào database
		$data = $request->getPost()->toArray();
		$file = $request->getFiles()->toArray();

		$data = array_merge($data,$file);
			
		$form->setData($data);

		if(!$form->isValid()){
			return new ViewModel(['form'=>$form]);
		}

		//Upload file hình
		$arrImage = [];
		foreach($data['image'] as $image){
			$newName = time().'-'.$image['name'];
			$arrImage[] = $newName;
			//Doi ten file
			$rename = new Rename([
                    'target'=>FILE_PATH.'images/'.$newName,
                    'overwrite'=>true
                ]);
			//Upload file hình
			$result = $rename->filter($image);
		}

		$jsonImage = json_encode($arrImage);
		$data['image'] = $jsonImage;

		//Lưu ngày add
		$data['update_at'] = date('Y-m-d',time());

		// idUrl
		$alias = changeTitle($data['name']);
		$data['id_url'] = $this->table->saveUrl($alias);
		
		//Lưu db
		$product = new Products;
        $product->exchangeArray($data);
        $this->table->saveProduct($product);
        
        $this->flashMessenger()->addSuccessMessage('Thêm thành công');
        return $this->redirect()->toRoute('products',[
            'controller'=>'product',
            'action'=>'index'
        ]);

		
	}

	function editAction(){
		$id = (int)$this->params()->fromRoute('page');

		//Kiểm tra id sp có tồn tại ko
		$flag = true;
		$product = $this->table->findProduct($id);
		if ($id===0) $flag = false;

		//In ra thông báo
		if (!$flag) {
			$this->flashMessenger()->addWarningMessage('Không tìm thấy sản phẩm');
        	return $this->redirect()->toRoute('products',[
            'controller'=>'product',
            'action'=>'index'
        	]);
		}

		$form = new ProductForm('edit');

		//Lấy loại cho product
		$types = $this->table->getAllType();
		$arrType = [];
		foreach($types as $type){
			$arrType[$type['id']] = $type['name'];
		}
		$form->get('id_type')->setValueOptions($arrType);
		
		$form->bind($product); //Lấy thông tin cũ cho vào form

		$request = $this->getRequest();
		if(!$request->isPost()){
			return new ViewModel(['form'=>$form,'product'=>$product]);
		}

		$file = $request->getFiles()->toArray();

		$data = $request->getPost()->toArray();
		$data = array_merge($data,$file);

		//Kiểm tra có chọn lại hình mới hay ko
		if($data['image'][0]['error']>0){
			$data['image'] = $product->image;
		}
		else{
			//Upload file hình mới
			$arrImage = [];
			foreach($data['image'] as $image){
				$newName = time().'-'.$image['name'];
				$arrImage[] = $newName;
				//Doi ten file
				$rename = new Rename([
	                    'target'=>FILE_PATH.'images/'.$newName,
	                    'overwrite'=>true
	                ]);
				//Đổi tên file hình
				$rename->filter($image);
			}

			$jsonImage = json_encode($arrImage);
			$data['image'] = $jsonImage;

		}

		$data['id_url'] = $product->id_url;
		
		$data['update_at'] = date('Y-m-d',time());
		
		$alias = changeTitle($data['name']);
        $this->table->updateUrl($alias,$product->id_url);

		//Lưu db
		$product = new Products;
        $product->exchangeArray($data);
        $this->table->saveProduct($product);
        
        $this->flashMessenger()->addSuccessMessage('Sửa thành công');
        return $this->redirect()->toRoute('products',[
            'controller'=>'product',
            'action'=>'index'
        ]);
		
	}

	function deleteAction(){
		 $id = (int)$this->params()->fromRoute('page'); //id
        $flag = true;
        if($id===0) $flag = false;
        $product = $this->table->findProduct($id);
        if(!$product) $flag = false;
        if(!$flag){
            $this->flashMessenger()->addWarningMessage('Không tìm thấy sản phẩm');
            return $this->redirect()->toRoute('products',[
                'controller'=>'product',
                'action'=>'index'
            ]);
        }
        $request = $this->getRequest();
        if(!$request->isPost()){
            return new ViewModel([
                'id'=>$id,
                'product'=>$product
            ]);
        }
        $btn = $request->getPost('del', 'No');
        if($btn=='Yes'){
            $this->table->deleteProduct($id);
            $this->flashMessenger()->addSuccessMessage('Xoá thành công');
        }
        return $this->redirect()->toRoute('products',[
            'controller'=>'product',
            'action'=>'index'
        ]);

	}
}