<?php

declare(strict_types = 1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class PerguntasController extends Abstracao\API {

    public function estadoAction() {
        $codigoEstado = $this->params()->fromRoute('id');
        if (empty($codigoEstado)) {
            $this->populaResposta(404, ['messages' => "Código do estado deve ser informado!"], false);
        } else {
            $modelMunicipios = new \Application\Model\MunicipiosModel();
            $this->populaResposta(200, $modelMunicipios->getAll($codigoEstado));
        }
        exit;
    }

}
