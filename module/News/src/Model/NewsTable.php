<?php
namespace News\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Sql;

class NewsTable {

    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
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
        $select->order('n.idbv DESC');
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


}