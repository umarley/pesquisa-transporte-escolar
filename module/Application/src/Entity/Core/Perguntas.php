<?php

namespace Db\Core;

use Db\Core\AbstractDatabase;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\TableIdentifier;
use Laminas\Db\Sql\Predicate\Expression;

class Perguntas extends AbstractDatabase {

    public function __construct() {
        $this->table = 'perguntas';
        $this->primaryKey = 'id_pergunta';
        parent::__construct(AbstractDatabase::DATABASE_CORE);
    }
    

}
