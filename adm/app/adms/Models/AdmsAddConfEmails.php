<?php

namespace App\adms\Models;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }

/** Cadastrar Configuração do email no banco de dados
*/
class AdmsAddConfEmails
{
    /**recebe as informações do formulario */
    private array|null $data;
    
   /**recebe true se executar com sucesso e false se houver Erro - */
    private $result;

    private array $listRegistryAdd;

   
    

    function getResult()
    {
        return $this->result;
        // var_dump($this->result);
    }
        /** 
     * Recebe os valores do formulário.
     * Instancia o helper "AdmsValEmptyField" para verificar se todos os campos estão preenchidos
     * Retorna FALSE quando algum campo está vazio
     * 
     * @param array $data Recebe as informações do formulário
     * 
     * @return void
     */
    public function create(array $data = null)
    {
        $this->data = $data;
        // var_dump($this->data);

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();       
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->add();
             
        } else {
            $this->result = false;
        }
    }

    
    /**
     *Cadastrar usuário no banco de dados
     * Retorna TRUE quando cadastrar o usuário com sucesso
     * Retorna FALSE quando não cadastrar o usuário
     *
     * @return void
     */
    private function add(): void
    {
       
        $this->data['created'] = date("Y-m-d H:i:s");

        var_dump( $this->data);

        $createConfEmail = new \App\adms\Models\helper\AdmsCreate();
        $createConfEmail->exeCreate("adms_confs_emails", $this->data);

        if( $createConfEmail->getResult()){
             $_SESSION['msg'] = "<p style='color: green;'>Configuração de e-mail cadastrada com sucesso!</p>";
             $this->result = true;
           
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro - 0092: Configuração de e-mail não cadastrado com sucesso!</p>";
            $this->result = false;
        }      
     
    }
}