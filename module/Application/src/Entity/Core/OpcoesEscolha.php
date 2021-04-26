<?php

namespace Db\Core;

use Db\Core\AbstractDatabase;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\TableIdentifier;
use Laminas\Db\Sql\Predicate\Expression;

class OpcoesEscolha extends AbstractDatabase {

    public function __construct() {
        $this->table = 'opcoes_escolha';
        $this->primaryKey = 'id';
        parent::__construct(AbstractDatabase::DATABASE_CORE);
    }
    
    public function getListaOpcoesByPergunta($idPergunta){
        $sql = "SELECT id, texto FROM opcoes_escolha WHERE id_pergunta = {$idPergunta}";
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
