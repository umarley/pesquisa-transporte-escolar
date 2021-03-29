<?php

declare(strict_types = 1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class EscolasController extends Abstracao\API {

    public function buscarAction() {
        $termo = $this->params()->fromRoute('id');
        $codigoMunicipio = $this->params()->fromRoute('municipio');
        if (empty($codigoMunicipio) || empty($termo)) {
            $this->populaResposta(404, ['messages' => "Código do municipio e o nome da escola devem ser informados!"], false);
        } else {
            $modelEscolas = new \Application\Model\EscolasModel();
            $this->populaResposta(200, $modelEscolas->find($termo, $codigoMunicipio));
        }
        exit;
    }

}
