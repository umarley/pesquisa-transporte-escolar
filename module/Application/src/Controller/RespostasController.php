<?php

declare(strict_types = 1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class RespostasController extends Abstracao\API {

    public function indexAction() {

        $conteudo = file_get_contents("php://input");
        $arPost = json_decode($conteudo, true);
        $modelResposta = new \Application\Model\RespostaModel();
        $idQuestionario = $arPost['id_questionario'];
        $modelResposta->processarRespostas($idQuestionario, $arPost['respostas']);
        $this->populaResposta(200, ['result' => true, 'messages' => "Questionário respondido com sucesso!"], false);
        exit;
    }

}
