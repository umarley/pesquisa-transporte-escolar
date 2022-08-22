<?php

namespace Db\Core;

use Db\Core\AbstractDatabase;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\TableIdentifier;
use Laminas\Db\Sql\Predicate\Expression;

class TipoPergunta extends AbstractDatabase {

    const MULTIPLA_ESCOLHA = '1';
    const CAIXA_SELECAO = '2';
    const RESPOSTA_CURTA = '3';
    const RESPOSTA_LONGA = '4';
    const GRADE_MULTIPLA_ESCOLHA = '5';
    const SELECT = '6';
    const AUTO_COMPLETE = '7';
    const RESPOSTA_MATRIZ = '8';
    const SEARCH = '9';
    const RESPOSTA_MATRIZ_NUMBER = '10';
    
    const MODEL_APIS = [
        'select-estado' => 'estados',
        'select-municipios' => 'municipios/estado/{pai}',
        'select-escolas' => 'escolas/buscar/{pai}',
        'search-escolas' => 'escolas/get/{id}'
    ];
    
    public function __construct() {
        $this->table = 'tipo_pergunta';
        $this->primaryKey = 'id_tipo';
        parent::__construct(AbstractDatabase::DATABASE_CORE);
    }
    

    

}
