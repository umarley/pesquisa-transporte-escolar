<?php

namespace Application\Model;

class QuestionariosModel {

    protected $_entity;

    public function __construct() {
        $this->_entity = new \Db\Core\Questionarios();
    }

    public function getAll() {
        return $this->_entity->getLista();
    }

    public function questionarioValido($idQuestionario) {
        $dbCoreQuestionario = new \Db\Core\Questionarios();
        if (!$dbCoreQuestionario->questionarioPodeSerRespondido($idQuestionario)) {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: PUT, GET, POST, PATCH, DELETE, OPTIONS');
            header('Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept');
            header('Content-Type: application/json', true, 404);
            echo json_encode(['result' => false, 'messages' => "Questionário não pode mais ser respondido."]);
            exit;
        }
    }

    public function montarQuestionario($idQuestionario) {
        $dbCorePerguntas = new \Db\Core\Perguntas();
        $dbCoreQuestionario = new \Db\Core\Questionarios();
        $arPerguntas = $dbCorePerguntas->getListaPerguntasByQuestionario($idQuestionario);
        foreach ($arPerguntas as $key => $row) {
            $arPerguntas[$key] = $this->processarPergunta($row, $idQuestionario);
        }
        return [
            'perguntas' => $arPerguntas,
            'titulo' => $dbCoreQuestionario->getNomeById($idQuestionario),
            'texto' => $dbCoreQuestionario->getTextoById($idQuestionario),
            'glossario' => $dbCoreQuestionario->getGlossarioById($idQuestionario)
        ];
    }

    private function processarPergunta($rowPergunta, $idQuestionario) {
        $urlHelper = new \Application\Utils\UrlHelper();
        switch ($rowPergunta->tipo) {
            case \Db\Core\TipoPergunta::SEARCH:
                $rowPergunta['api'] = $urlHelper->baseUrl(\Db\Core\TipoPergunta::MODEL_APIS[$rowPergunta['model']]);
                unset($rowPergunta['model']);
                break;
            case \Db\Core\TipoPergunta::SELECT:
                $rowPergunta['api'] = $urlHelper->baseUrl(\Db\Core\TipoPergunta::MODEL_APIS[$rowPergunta['model']]);
                unset($rowPergunta['model']);
                break;
            case \Db\Core\TipoPergunta::CAIXA_SELECAO:
                unset($rowPergunta['model']);
                unset($rowPergunta['pai']);
                $rowPergunta = $this->getOpcoesPergunta($rowPergunta);
                break;
            case \Db\Core\TipoPergunta::AUTO_COMPLETE:
                unset($rowPergunta['model']);
                unset($rowPergunta['pai']);
                break;
            case \Db\Core\TipoPergunta::GRADE_MULTIPLA_ESCOLHA:
                $dbCorePerguntas = new \Db\Core\Perguntas();
                $rowPergunta = $this->getOpcoesPergunta($rowPergunta, 'colunas');
                $rowPergunta['itens'] = $dbCorePerguntas->getItensGradeMultiplaEscolha($rowPergunta['id_pergunta'], $idQuestionario);
                unset($rowPergunta['model']);
                unset($rowPergunta['pai']);
                break;
            case \Db\Core\TipoPergunta::MULTIPLA_ESCOLHA:
                unset($rowPergunta['model']);
                unset($rowPergunta['pai']);
                $rowPergunta = $this->getOpcoesPergunta($rowPergunta);
                break;
            case \Db\Core\TipoPergunta::RESPOSTA_CURTA:
                unset($rowPergunta['model']);
                unset($rowPergunta['pai']);
                break;
            case \Db\Core\TipoPergunta::RESPOSTA_LONGA:
                unset($rowPergunta['model']);
                unset($rowPergunta['pai']);
                break;
            case \Db\Core\TipoPergunta::RESPOSTA_MATRIZ:
                $dbCorePerguntas = new \Db\Core\Perguntas();
                unset($rowPergunta['model']);
                unset($rowPergunta['pai']);
                $rowPergunta['itens'] = $dbCorePerguntas->getItensGradeMultiplaEscolha($rowPergunta['id_pergunta']);
                break;
        }

        return $rowPergunta;
    }

    private function getOpcoesPergunta($rowPergunta, $key = 'opcoes') {
        $dbCoreOpcoesEscolha = new \Db\Core\OpcoesEscolha();
        $rowPergunta[$key] = $dbCoreOpcoesEscolha->getListaOpcoesByPergunta($rowPergunta['id_pergunta']);
        return $rowPergunta;
    }

    public function find($codigoMunicipio) {
        return [];
    }

}
