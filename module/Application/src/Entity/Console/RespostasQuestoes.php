<?php

namespace Db\Console;

use Db\Core\AbstractDatabase;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\TableIdentifier;
use Laminas\Db\Sql\Predicate\Expression;

class RespostasQuestoes extends AbstractDatabase {

    public function __construct() {
        $this->table = 'respostas_q1';
        $this->primaryKey = 'rowId';
        parent::__construct(AbstractDatabase::DATABASE_CORE);
    }

    public function registroJaExiste($rowId) {
        $sql = "SELECT COUNT(*) AS qtd FROM {$this->table} r WHERE  = '{$rowId}'";
        $sql = new Sql($this->AdapterBD);
        $select = $sql->select($this->tableIdentifier)
                ->columns(['qtd' => new \Laminas\Db\Sql\Expression("count(*)")])
                ->where("{$this->primaryKey} = '{$rowId}'");
        $sqlBuild = $sql->buildSqlString($select);
        $statement = $this->AdapterBD->createStatement($sqlBuild);
        $statement->prepare();
        $row = $statement->execute()->current();
        if ($row['qtd'] > 0) {
            return true;
        } else {
            return false;
        }
    }

}
