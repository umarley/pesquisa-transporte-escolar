<?php

declare(strict_types = 1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class RespostasController extends Abstracao\API {

    public function indexAction() {

            $conteudo = file_get_contents("php://input");
            $arPost = json_decode($conteudo, true);

            var_dump($arPost);
        
        exit;
    }

    /* public function estadoAction() {
      $codigoEstado = $this->params()->fromRoute('id');
      if (empty($codigoEstado)) {
      $this->populaResposta(404, ['messages' => "Código do estado deve ser informado!"], false);
      } else {
      $modelMunicipios = new \Application\Model\MunicipiosModel();
      $this->populaResposta(200, $modelMunicipios->getAll($codigoEstado));
      }
      exit;
      } */
}
