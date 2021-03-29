<?php

namespace Db\Core;

use Db\Core\AbstractDatabase;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\TableIdentifier;
use Laminas\Db\Sql\Predicate\Expression;

class Municipio extends AbstractDatabase {

    public function __construct() {
        $this->table = 'glb_municipio';
        $this->primaryKey = 'id_cidade';
        parent::__construct(AbstractDatabase::DATABASE_CORE);
    }
    
    public function getLista($codigoUF){
        $sql = new Sql($this->AdapterBD);
        $select = $sql->select($this->tableIdentifier)
                ->columns(['id_cidade', 'codigo_ibge', 'nome'])
                ->where("codigo_uf = {$codigoUF}")
                ->order('nome ASC');
        $prepare = $sql->prepareStatementForSqlObject($select);
        $this->getResultSet($prepare->execute());
        $arLista = [];
        foreach ($this->resultSet as $row){
            $arLista[] = $row;
        }
        return $arLista;
    }
    

}
