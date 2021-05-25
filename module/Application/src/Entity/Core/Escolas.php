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

    public function procurarEscolaPorMunicipio($municipio) {
        $sql = new Sql($this->AdapterBD);
        $select = $sql->select($this->tableIdentifier)
                ->columns(['CO_ENTIDADE', 'NO_ENTIDADE'])
                ->where("CO_MUNICIPIO = {$municipio}")
                ->order("NO_ENTIDADE ASC");
        $prepare = $sql->prepareStatementForSqlObject($select);
        $arLista = [];
        $this->getResultSet($prepare->execute());
        foreach ($this->resultSet as $row) {
            $arLista[] = $row;
        }
        return $arLista;
    }
    
    public function getEscolaById($codigoEscola){
        $sql = "SELECT esc.NO_ENTIDADE as nm_escola, mun.nome as cidade, est.nome as estado FROM glb_escolas esc
                INNER JOIN glb_municipio mun ON esc.CO_MUNICIPIO = mun.codigo_ibge
                INNER JOIN glb_estado est ON est.codigo = mun.codigo_uf
                WHERE esc.CO_ENTIDADE = {$codigoEscola}
                LIMIT 1";
        $statement = $this->AdapterBD->createStatement($sql);
        $row = $statement->execute()->current();
        return $row;
    }

}
