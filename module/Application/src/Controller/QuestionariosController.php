<?php

declare(strict_types = 1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class QuestionariosController extends Abstracao\API {

    public function indexAction() {
        $modelQuestionario = new \Application\Model\QuestionariosModel();
        $this->populaResposta(200, $modelQuestionario->getAll());

        exit;
    }
    
    public function perguntasAction(){
        $idQuestionario = $this->params()->fromRoute('param1');
        if(!empty($idQuestionario)){
            $modelQuestionario = new \Application\Model\QuestionariosModel();
            $this->populaResposta(200, $modelQuestionario->montarQuestionario($idQuestionario));
        }else{
            $this->populaResposta(400, ['messages' => "o ID do questionário deve ser informados!"], false);
        }
        
        exit;
    }

}
