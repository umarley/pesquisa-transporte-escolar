<?php
namespace Application\Model;

class MunicipiosModel {
    
    protected $_entity;
    
    public function __construct() {
        $this->_entity = new \Db\Core\Municipio();
    }
    
    public function getAll($codigoEstado){
        return $this->_entity->getLista($codigoEstado);
    }
    
}

