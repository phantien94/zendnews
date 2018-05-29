<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace News\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use News\Model\NewsTable;
use News\Model\News;
use News\Form\NewsForm;
use Zend\Filter\File\Rename;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter;

class NewsController extends AbstractActionController
{
    public $table;
    function __construct(NewsTable $table){
        $this->table = $table;
    }
    
    function testDBAction(){
        echo $this->table->testConnect();   
    }
    function indexAction()
    {   
        $page = $this->params()->fromRoute('page');
        $result = $this->table->fetchAll();

        $arrNews = [];
        foreach($result as $n){
            $arrNews[] = $n; 
        }

        $paginator = new Paginator(new Adapter\ArrayAdapter($arrNews));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(5);
        $paginator->setPageRange(5);

        return new ViewModel(['result'=>$paginator]);
        
    }

    function addAction(){
        $form = new NewsForm();
        $types = $this->table->getAllType();
        $arrType = [];
        foreach ($types as $type) {
            $arrType[$type['idloai']] = $type['TenLoai'];
        }
        // print_r($type);
        // return false;
        $form->get('idLoai')->setValueOptions($arrType);
        
        $request = $this->getRequest();

        if($request->isGet()){
            return new ViewModel(['form'=>$form]);
        }

        $data = $request->getPost()->toArray();
        $file = $request->getFiles()->toArray();
        $data = array_merge($data,$file);

        $form->setData($data);


        if(!$form->isValid()){
            return new ViewModel(['form'=>$form]);  
        }

        // Alias
       
        $data['Alias'] = changeTitle($data['TieuDe']);

        //Lưu hình ảnh
        $arrImage = [];
        foreach($data['urlHinh'] as $image){
            $newName = time().'-'.$data['Alias'];
            $arrImage[] = $newName;
            
            //Đổi tên file hình
            $rename = new Rename([
                'target'=>FILE_PATH.'images/'.$newName,
                'overwrite'=>true
            ]);
            
            $rename->filter($image);
            
        }
        
        //Upload file hình
        $jsonImage = json_encode($arrImage);
        $data['urlHinh'] = $jsonImage;

        $data['Ngay'] = date ('Y-m-d',time());
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // return false;

        $news = new News;
        $news->exchangeArray($data);
        $this->table->saveNews($news);

         return $this->redirect()->toRoute('news',[
            'controller'=>'news',
            'action'=>'index'
        ]);
    }

    function editAction(){
        
    }
    
}