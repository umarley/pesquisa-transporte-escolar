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
    
    public function getSelect(){
        $arLista = $this->_entity->getLista();
        $arSelect = [];
        foreach ($arLista as $key => $row){
            $arSelect[$key]['value'] = $row['codigo'];
            $arSelect[$key]['label'] = $row['nome'];
        }
        return $arSelect;
    }
    
}

