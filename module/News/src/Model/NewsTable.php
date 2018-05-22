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
        $select->order('n.idbv ASC');
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
}