<?php

namespace Db\Core;

use Db\Core\AbstractDatabase;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\TableIdentifier;
use Laminas\Db\Sql\Predicate\Expression;

class Questionarios extends AbstractDatabase {

    public function __construct() {
        $this->table = 'questionario';
        $this->primaryKey = 'id';
        parent::__construct(AbstractDatabase::DATABASE_CORE);
    }
    
    public function getLista(){
        $sql = "SELECT id, titulo FROM questionario q
                    WHERE NOW() BETWEEN q.dt_inicio AND q.dt_final
                    AND is_ativo = 'S'";
        $statement = $this->AdapterBD->createStatement($sql);
        $statement->prepare();
        $arLista = [];
        $this->getResultSet($statement->execute());
        foreach ($this->resultSet as $row){
            $arLista[] = $row;
        }
        return $arLista;
    }
    

}
