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
    
    public function find($codigoMunicipio){
        return $this->_entity->procurarEscolaPorMunicipio($codigoMunicipio);
    }
    
    public function getSelect($codigoMunicipio){
        $arData = $this->_entity->procurarEscolaPorMunicipio($codigoMunicipio);
        $arSelect = [];
        foreach ($arData as $key => $row){
            $arSelect[$key]['value'] = $row['CO_ENTIDADE'];
            $arSelect[$key]['label'] = $row['CO_ENTIDADE'] . " - " . $row['NO_ENTIDADE'];
        }
        return $arSelect;
    }
}

