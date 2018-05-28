<?php
namespace News\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Sql;

class NewsTable {

<<<<<<< HEAD
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
=======
	private $tableGateway;

	public function __construct(TableGatewayInterface $tableGateway)
>>>>>>> af9d8f8f41c870163dd2ebd2d19db89d4027516a
    {
        $this->tableGateway = $tableGateway;
    }

    function testConnect(){//get table name
        return $this->tabelGateway->getTable();
    }

    public function fetchAll()
    {
        $adapter = $this->tableGateway->getAdapter();

        $sql = new Sql($adapter);
        $select = $sql->select(['n'=>'tintuc']);
        $select->join(
            ['p'=>'phanloaibai'],
            'p.idloai = n.idLoai',
            [
                'loai'=>'TenLoai'
            ]
        );
        //$select->where('AnHien=1');
<<<<<<< HEAD
        $select->order('n.idbv DESC');
=======
        $select->order('n.idbv ASC');
>>>>>>> af9d8f8f41c870163dd2ebd2d19db89d4027516a
        $statement = $sql->prepareStatementForSqlObject($select);
        return $results = $statement->execute();

    }

    public function getAllType(){
        $adapter = $this->tableGateway->getAdapter();

        $sql = new Sql($adapter);
        $select = $sql->select('phanloaibai')->where('AnHien=1');

        $statement = $sql->prepareStatementForSqlObject($select);
        return $results = $statement->execute();
    }

    public function saveNews(News $data,$idbv=0){
<<<<<<< HEAD
        // print_r($data);
        // die;
        $news = [
            'lang'=>$data->lang,
            'TieuDe'=>$data->TieuDe,
            'TomTat'=>$data->TomTat,
            'Alias'=>$data->Alias,
            'urlHinh'=>$data->urlHinh,
            'Ngay'=>$data->Ngay,
            'Content'=>$data->Content,
            'idLoai'=>$data->idLoai,
            'NoiBat'=>$data->NoiBat,
            'AnHien'=>$data->AnHien,

        ];
        return $this->tableGateway->insert($news);

        // if($idbv==0){
        //     return $this->tableGateway->insert($news);
        // }
        // return $this->tabelGateway->update(
        //     $news,
        //     "idbv=$idbv"
        // );
    }


=======
        $news = [

            

        ];
    }
>>>>>>> af9d8f8f41c870163dd2ebd2d19db89d4027516a
}