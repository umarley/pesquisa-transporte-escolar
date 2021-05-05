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
    
    public function getSelect($codigoEstado){
        $arData = $this->_entity->getLista($codigoEstado);
        $arSelect = [];
        foreach ($arData as $key => $row){
            $arSelect[$key]['value'] = $row['codigo_ibge'];
            $arSelect[$key]['label'] = $row['nome'];
        }
        return $arSelect;
    }
    
}

