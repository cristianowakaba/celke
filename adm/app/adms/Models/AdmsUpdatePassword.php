<?php

namespace App\adms\Models;



/** 
 * confirmar a chave atualizar senha. e cadastrar nova senha
 */
class AdmsUpdatePassword
{
    /* recebe a chave para atualizar a senha */
    private string $key;
    /**recebe true se executar com sucesso e false se houver erro */
    private $result;
    /**Recebe os registros do banco de dados */
    private array|null $resultBd;
    /**
     * recebe os valores que devem ser salvos no banco de dados.
     *
     * @var array
     */
    private array $dataSave;


    function getResult()
    {
        return $this->result;
        // var_dump($this->result);
    }

    public function valKey(string $key): void
    {
        $this->key = $key;
        // var_dump($this->key);
        $viewKeyUpPass = new \App\adms\Models\helper\AdmsRead();
        $viewKeyUpPass->fullRead("SELECT id FROM adms_users WHERE recover_password =:recover_password LIMIT :limit", "recover_password={$this->key}&limit=1");
        $resultBd = $viewKeyUpPass->getResult();
        
        
        if($resultBd){
            // var_dump( $resultBd );
            
            $this->result=true;
          
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link inválido, solicite novo link <a href='" . URLADM . "recover-password/index'>clique aqui</a>!</p>";
            $this->result = false;
           
            
        }
    }
}
