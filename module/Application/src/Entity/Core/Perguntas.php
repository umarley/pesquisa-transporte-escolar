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
    
    public function getListaPerguntasByQuestionario($idQuestionario){
        $sql = "SELECT p.id_pergunta, p.ordem, p.enunciado, tipo, model, pai, mostrar, required FROM perguntas p
                    WHERE id_questionario = {$idQuestionario}
                    AND p.sub_ordem IS NULL
                    ORDER BY ordem ASC";
        $statement = $this->AdapterBD->createStatement($sql);
        $statement->prepare();
        $arLista = [];
        $this->getResultSet($statement->execute());
        foreach ($this->resultSet as $key => $row){
            if(empty($row['mostrar'])){
                unset($row['mostrar']);
            }
            $arLista[$key] = $row;
        }
        return $arLista;
    }
    
    private function processarRegrasExibicao($sMostrar){
        $partsPergunta = explode("/", $sMostrar);
        $pergunta = $partsPergunta[0];
        $partsOpcoes = explode(",", $partsPergunta[1]);
        return ['id_pergunta' => $pergunta, 'opcoes' => $partsOpcoes];
    }
    
    
    public function getItensGradeMultiplaEscolha($idPergunta, $idQuestionario){
        $sql = "SELECT id_pergunta, sub_ordem as sub_id, enunciado "
                . "FROM perguntas p WHERE p.sub_ordem LIKE '{$idPergunta}%' AND p.id_questionario = {$idQuestionario}";
        $statement = $this->AdapterBD->createStatement($sql);
        $statement->prepare();
        $arLista = [];
        $this->getResultSet($statement->execute());
        foreach ($this->resultSet as $row){
            $arLista[] = $row;
        }
        return $arLista;
    }
    
    public function getTipoPergunta($idPergunta){
        $sql = "SELECT tipo FROM perguntas p
                    WHERE p.id_pergunta = {$idPergunta}";
                    $statement = $this->AdapterBD->createStatement($sql);
        $statement->prepare();
        $row = $statement->execute()->current();
        return $row['tipo'];
    }

}
