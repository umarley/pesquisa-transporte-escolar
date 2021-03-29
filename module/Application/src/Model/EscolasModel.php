<?php
namespace Application\Model;

class EscolasModel {
    
    protected $_entity;
    
    public function __construct() {
        $this->_entity = new \Db\Core\Escolas();
    }
    
    public function getAll($codigoEstado){
        return $this->_entity->getLista($codigoEstado);
    }
    
    public function find($termo, $codigoMunicipio){
        return $this->_entity->procurarEscolaPorTermoAndMunicipio($termo, $codigoMunicipio);
    }
}

