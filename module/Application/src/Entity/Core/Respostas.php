<?php

namespace Db\Core;

use Db\Core\AbstractDatabase;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\TableIdentifier;
use Laminas\Db\Sql\Predicate\Expression;

class Respostas extends AbstractDatabase {

    public function __construct() {
        $this->table = 'respostas';
        $this->primaryKey = 'id_resposta';
        parent::__construct(AbstractDatabase::DATABASE_CORE);
    }
    
    

}
