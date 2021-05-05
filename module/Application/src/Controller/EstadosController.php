<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */
declare(strict_types = 1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class EstadosController extends Abstracao\API {

    public function indexAction() {
        $modelEstados = new \Application\Model\EstadosModel();  
        $this->populaResposta(200, $modelEstados->getSelect());
        exit;
    }

}
