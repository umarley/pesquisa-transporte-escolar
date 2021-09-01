<?php

namespace Db\Console;

use Db\Core\AbstractDatabase;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\TableIdentifier;
use Laminas\Db\Sql\Predicate\Expression;

class StageRespostas extends AbstractDatabase {

    public function __construct() {
        $this->table = 'stage_respostas';
        $this->primaryKey = 'id';
        parent::__construct(AbstractDatabase::DATABASE_CORE);
    }
    
    public function getLista() {
        $sql = new Sql($this->AdapterBD);
        $select = $sql->select($this->tableIdentifier)
                ->columns(['*']);
        $arLista = [];
        $prepare = $sql->prepareStatementForSqlObject($select);
        $this->getResultSet($prepare->execute());
        foreach ($this->resultSet as $row) {
            $arLista[] = $row;
        }
        return $arLista;
    }
    
    

}
