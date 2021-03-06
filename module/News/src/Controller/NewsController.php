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
use News\Form\SearchForm;
use Zend\Filter\File\Rename;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

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


        $types = $this->table->getAllType();

        $arrNews = [];
        foreach($result as $n){
            $arrNews[] = $n; 
        }

        $paginator = new Paginator(new Adapter\ArrayAdapter($arrNews));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(5);
        $paginator->setPageRange(5);

        return new ViewModel(['result'=>$paginator,'types'=>$types]);
        
    }

    function hotNewsAction()
    {   
        $page = $this->params()->fromRoute('page');
        $result = $this->table->popular();

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

    function searchAction(){
        $form = new SearchForm();
          $request = $this->getRequest();
         if($request->isGet()){
            return new ViewModel(['form'=>$form]);
        }
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

        $data['Ngay'] = date ('Y-m-d H:i:s',time());
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // return false;

        $news = new News;
        $news->exchangeArray($data);
        $this->table->saveNews($news);

        
        
        //$this->flashMessenger()->addSuccessMessage('Thêm thành công');

        return $this->redirect()->toRoute('news',[
            'controller'=>'news',
            'action'=>'index'
        ]);
    }

    function editAction(){
        $idbv = (int)$this->params()->fromRoute('page');
        $flag = true;

        if($idbv===0) $flag=false;

        $news = $this->table->findId($idbv);

        if(!$news) $flag=false;

        if(!$flag){
            //$this->flashMessenger()->addWarningMessage('Không tìm thấy bài viết');
            return $this->redirect()->toRoute('news',[
                'controller'=>'news',
                'action'    =>'index'
            ]);
        }
        // print_r($news);
        // return false;

        $form = new NewsForm('edit');
        
        $types = $this->table->getAllType();
        $arrType = [];
        foreach($types as $type){
            $arrType[$type['idloai']] = $type['TenLoai'];
        }

        $form->get('idLoai')->setValueOptions($arrType);

        $form->bind($news);

        $request = $this->getRequest();

        if(!$request->isPost()){
            return new ViewModel(['form'=>$form,'news'=>$news]);
        }

        $data = $request->getPost()->toArray();
        $file = $request->getFiles()->toArray();

        $data = array_merge($data,$file);

        $data['Alias'] = changeTitle($data['TieuDe']);
        
        if($data['urlHinh'][0]['error']>0){
            $data['urlHinh'] = $news->urlHinh;
        }
        else{
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
        
        }

        
        $data['Ngay'] = date ('Y-m-d H:i:s',time());

        $news = new News;
        $news->exchangeArray($data);
        $this->table->saveNews($news,$idbv);

        echo "Updated";

         return $this->redirect()->toRoute('news',[
            'controller'=>'news',
            'action'=>'index'
        ]);
    }

    function deleteAction(){
        // $this->table->deleteNews($idbv);
        // return false;

        $idbv = (int)$this->params()->fromRoute('page');

        $flag = true;

        if($idbv===0) $flag=false;

        $news = $this->table->findId($idbv);

        if(!$news) $flag=false;

        if(!$flag){
             //$this->flashMessenger()->addWarningMessage('Không tìm thấy bài viết');
            return $this->redirect()->toRoute('news',[
                'controller'=>'news',
                'action'    =>'index'
            ]);
        }

        $request = $this->getRequest();

        if(!$request->isPost()){
            return new ViewModel(['idbv'=>$idbv,'news'=>$news]);
        }

        //$this->table->deleteNews($idbv);

        $btn = $request->getPost('del', 'No');
        if($btn=='Yes'){
            $this->table->deleteNews($idbv);
        }

        //$this->flashMessenger()->addSuccessMessage('Bài viết đã được xóa');

        return $this->redirect()->toRoute('news',[
            'controller'=>'news',
            'action'=>'index'
        ]);
    
    
    }
    function backupAction(){
        // $this->table->deleteNews($idbv);
        // return false;

        $idbv = (int)$this->params()->fromRoute('page');

        $flag = true;

        if($idbv===0) $flag=false;

        $news = $this->table->findId($idbv);

        if(!$news) $flag=false;

        if(!$flag){
             //$this->flashMessenger()->addWarningMessage('Không tìm thấy bài viết');
            return $this->redirect()->toRoute('news',[
                'controller'=>'news',
                'action'    =>'index'
            ]);
        }

        $request = $this->getRequest();

        if(!$request->isPost()){
            return new ViewModel(['idbv'=>$idbv,'news'=>$news]);
        }


        $btn = $request->getPost('del', 'No');
        if($btn=='Yes'){
            $this->table->backupNews($idbv);
        }

        return $this->redirect()->toRoute('news',[
            'controller'=>'news',
            'action'=>'index'
        ]);
    
    
}
    function deletedListAction()
    {   
        $page = $this->params()->fromRoute('page');
        $result = $this->table->deletedList();

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

}