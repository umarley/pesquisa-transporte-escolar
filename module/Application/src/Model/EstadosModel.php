<?php
namespace Application\Model;

class EstadosModel {
    
    protected $_entity;
    
    public function __construct() {
        $this->_entity = new \Db\Core\Estado();
    }
    
    public function getAll(){
        return $this->_entity->getLista();
    }
    
}

