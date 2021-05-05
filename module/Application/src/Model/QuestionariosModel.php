<?php
namespace Application\Model;

class QuestionariosModel {
    
    protected $_entity;
    
    public function __construct() {
        $this->_entity = new \Db\Core\Questionarios();
    }
    
    public function getAll(){
        return $this->_entity->getLista();
    }
    
    public function montarQuestionario($idQuestionario){
        $dbCorePerguntas = new \Db\Core\Perguntas();
        $arPerguntas = $dbCorePerguntas->getListaPerguntasByQuestionario($idQuestionario);
        foreach ($arPerguntas as $key => $row){
            $arPerguntas[$key] = $this->processarPergunta($row);
        }
        
        return $arPerguntas;
    }
    
    private function processarPergunta($rowPergunta){
        $urlHelper = new \Application\Utils\UrlHelper();
        switch($rowPergunta->tipo){
            case \Db\Core\TipoPergunta::SELECT:
                $rowPergunta['api'] =  $urlHelper->baseUrl(\Db\Core\TipoPergunta::MODEL_APIS[$rowPergunta['model']]);
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
                $rowPergunta['itens'] = $dbCorePerguntas->getItensGradeMultiplaEscolha($rowPergunta['id_pergunta']);
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
    
    private function getOpcoesPergunta($rowPergunta, $key = 'opcoes'){
        $dbCoreOpcoesEscolha = new \Db\Core\OpcoesEscolha();
        $rowPergunta[$key] = $dbCoreOpcoesEscolha->getListaOpcoesByPergunta($rowPergunta['id_pergunta']);
        return $rowPergunta;
    }
    
    public function find($codigoMunicipio){
        return [];
    }
}

