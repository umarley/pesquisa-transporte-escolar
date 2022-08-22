<?php
namespace Application\Model;

class RespostaModel {
    
    protected $_entity;
    
    public function __construct() {
        $this->_entity = new \Db\Core\Respostas();
    }
    
    public function getAll(){
        return $this->_entity->getLista();
    }
    
    public function processarRespostas($idQuestionario, $arRespostas){
        $dbCoreResposta = new \Db\Core\Respostas();
        $arRespostasProcessadas = [];
        $groupResp = uniqid();
        foreach ($arRespostas as $key => $row){
            $idPergunta = str_replace("form_", "", $key);
            $arRespostasProcessadas[] = $this->processarRespostaIndividual($idPergunta, $row);
        }
        
        foreach ($arRespostasProcessadas as $row){
            $row['group_id'] = $groupResp;
            $row['data_resposta'] = date("Y-m-d H:i:s");
            $row['id_questionario'] = $idQuestionario;
            if(key_exists('opcoes', $row)){
                foreach ($row['opcoes'] as $rowOpcoes){
                    $row['id_pergunta'] = $rowOpcoes['id_pergunta'];
                    $row['resposta_codigo'] = key_exists('resposta_codigo', $rowOpcoes) ? $rowOpcoes['resposta_codigo'] : null;
                    $row['resposta'] = key_exists('resposta', $rowOpcoes) ? $rowOpcoes['resposta'] : null;
                    $this->inserirOpcoes($row);
                }
            }else{
                $dbCoreResposta->_inserir($row);
            }
        }
    }
    
    private function inserirOpcoes($row){
        unset($row['opcoes']);
        $dbCoreResposta = new \Db\Core\Respostas();
        $arResult = $dbCoreResposta->_inserir($row);        
    }
    
    public function processarRespostaIndividual($idPergunta, $arResposta){
        $dbCorePergunta = new \Db\Core\Perguntas();
        $arRetorno = [];
        $tipoPergunta = $dbCorePergunta->getTipoPergunta($idPergunta);
        switch($tipoPergunta){
            case \Db\Core\TipoPergunta::MULTIPLA_ESCOLHA:
                $arRetorno['id_pergunta'] = $idPergunta;
                $arRetorno['resposta_codigo'] = $arResposta;
                break;
            case \Db\Core\TipoPergunta::SEARCH:
                $arRetorno['id_pergunta'] = $idPergunta;
                $arRetorno['resposta_select'] = $arResposta;
                break;
            case \Db\Core\TipoPergunta::SELECT:
                $arRetorno['id_pergunta'] = $idPergunta;
                $arRetorno['resposta_select'] = $arResposta;
                break;
            case \Db\Core\TipoPergunta::GRADE_MULTIPLA_ESCOLHA:
                $arRetorno['id_pergunta'] = $idPergunta;
                $arRetorno['opcoes'] = $this->processarGradeMultiplaEscolha($arResposta);
                break;
            case \Db\Core\TipoPergunta::CAIXA_SELECAO:
                $arRetorno['id_pergunta'] = $idPergunta;
                $arRetorno['opcoes'] = $this->processarCaixaSelecao($idPergunta, $arResposta);
                break;
            case \Db\Core\TipoPergunta::RESPOSTA_MATRIZ:
                $arRetorno['id_pergunta'] = $idPergunta;
                $arRetorno['opcoes'] = $this->processarRespostaMatriz($arResposta);
                break;
            case \Db\Core\TipoPergunta::RESPOSTA_MATRIZ_NUMBER:
                $arRetorno['id_pergunta'] = $idPergunta;
                $arRetorno['opcoes'] = $this->processarRespostaMatriz($arResposta);
                break;
            default :
                $arRetorno['id_pergunta'] = $idPergunta;
                $arRetorno['resposta'] = $arResposta;
                break;
        }
        
        return $arRetorno;
    }
    
    private function processarGradeMultiplaEscolha($arResposta){
        $arRetorno = [];
        foreach ($arResposta as $key => $row){
            $idPergunta = str_replace("res_", "", $key);
            $arRetorno[] = ['id_pergunta' => $idPergunta, 'resposta_codigo' => $row];
        }
        return $arRetorno;
    }
    
    private function processarCaixaSelecao($idPergunta, $arResposta){
        $arRetorno = [];
        foreach ($arResposta as $key => $row){
            $resposta = str_replace("res_", "", $key);
            if($row){
                $arRetorno[] = ['id_pergunta' => $idPergunta, 'resposta_codigo' => $resposta];
            }
        }
        return $arRetorno;
    }
    
    private function processarRespostaMatriz($arResposta){
        $arRetorno = [];
        foreach ($arResposta as $key => $row){
            $idPergunta = str_replace("res_", "", $key);
            $arRetorno[] = ['id_pergunta' => $idPergunta, 'resposta' => $row];
        }
        return $arRetorno;
    }   
    
    public function find($codigoMunicipio){
        return [];
    }
}

