<?php

declare(strict_types = 1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class EscolasController extends Abstracao\API {

    public function buscarAction() {
        $codigoMunicipio = $this->params()->fromRoute('id');
        if (empty($codigoMunicipio)) {
            $this->populaResposta(400, ['messages' => "Código do municipio deve ser informados!"], false);
        } else {
            $modelEscolas = new \Application\Model\EscolasModel();
            $this->populaResposta(200, $modelEscolas->getSelect($codigoMunicipio));
        }
        exit;
    }
    
    
    public function getAction() {
        $codigoEscola = $this->params()->fromRoute('id');
        if (empty($codigoEscola)) {
            $this->populaResposta(400, ['messages' => "Código da escola deve ser informado!"], false);
        } else {
            $modelEscolas = new \Application\Model\EscolasModel();
            $this->populaResposta(200, $modelEscolas->getDadosSearch($codigoEscola));
        }
        exit;
    }

}
