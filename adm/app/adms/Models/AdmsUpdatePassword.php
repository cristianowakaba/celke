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
    private array|null $resultBd=null;
    /**
     * recebe os valores que devem ser salvos no banco de dados.
     *
     * @var array
     */
    private array $dataSave;
    /**recebe as informações do formulario o (email)*/
    private array|null $data;


    function getResult()
    {
        return $this->result;
        // var_dump($this->result);
    }

    public function valKey(string $key): bool
    {
        $this->key = $key;
        // var_dump($this->key);
        $viewKeyUpPass = new \App\adms\Models\helper\AdmsRead();
        $viewKeyUpPass->fullRead("SELECT id FROM adms_users WHERE recover_password =:recover_password LIMIT :limit", "recover_password={$this->key}&limit=1");
        
        $this->resultBd = $viewKeyUpPass->getResult();
       if( $this->resultBd){
             $this->result=true;
            return true;
            
          
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link inválido, solicite novo link <a href='" . URLADM . "recover-password/index'>clique aqui</a>!</p>";
            $this->result = false;
            return false;
            
        }
       
    }
    /**
     * instancia a helper para verificar se não há campos vazios
     *
     * @param array|null $data
     * @return void
     */
    public function editPassword(array $data=null):void
    {
        $this->data=$data;
        var_dump( $this->data);
        $valEmptyField =new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField ->valField($this->data);
        if($valEmptyField->getResult()){
            $this->valInput();
        }else{
            $this->result=false;
        }
    }
    /*validar senha e extensão da senha*/
    private function valInput():void
    {
       $valPassword= new \App\adms\Models\helper\AdmsValPassword();
       $valPassword->validatePassword($this->data['password']);
       if($valPassword->getResult()){
        if($this->valKey($this->data['key'])){
           $this->updatePassword();

        }else{
            $this->result=false;
        }
       }else{
        $this->result = false;
       }
    }
    /**
     * instancia esse método quando a chave é valida.
     * método que edita no banco de dados instanciando o helper
     *
     * @return void
     */
    private function updatePassword():void
    {
        $this->dataSave['recover_password'] = null;
        $this->dataSave['password'] = password_hash($this->data['password'], PASSWORD_DEFAULT);
        $this->dataSave['modified'] = date("Y-m-d H:i:s");

        $upPassword = new \App\adms\Models\helper\AdmsUpdate();
        $upPassword->exeUpdate("adms_users", $this->dataSave, "WHERE id=:id", "id={$this->resultBd[0]['id']}");
        if($upPassword->getResult()){
            $_SESSION['msg'] = "<p style='color: green;'>Senha atualizada com sucesso!</p>";
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Senha não atualizada, tente novamente!</p>";
            $this->result = false;
        }

    }
}
