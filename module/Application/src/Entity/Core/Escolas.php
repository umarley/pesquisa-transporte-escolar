<?php

namespace Db\Core;

use Db\Core\AbstractDatabase;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\TableIdentifier;
use Laminas\Db\Sql\Predicate\Expression;

class Escolas extends AbstractDatabase {

    public function __construct() {
        $this->table = 'glb_escolas';
        $this->primaryKey = 'CO_ENTIDADE';
        parent::__construct(AbstractDatabase::DATABASE_CORE);
    }

    public function procurarEscolaPorTermoAndMunicipio($termo, $municipio) {
        $sql = new Sql($this->AdapterBD);
        $select = $sql->select($this->tableIdentifier)
                ->columns(['CO_ENTIDADE', 'NO_ENTIDADE'])
                ->where("CO_MUNICIPIO = {$municipio}")
                ->where("NO_ENTIDADE LIKE '%{$termo}%'")
                ->order("NO_ENTIDADE ASC");
        $prepare = $sql->prepareStatementForSqlObject($select);
        $arLista = [];
        $this->getResultSet($prepare->execute());
        foreach ($this->resultSet as $row) {
            $arLista[] = $row;
        }
        return $arLista;
    }

}
