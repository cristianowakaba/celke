<?php

namespace App\adms\Models;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }

/** Cadastrar nivel de acesso no banco de dados
*/
class AdmsAddAccessLevels
{
    /**recebe as informações do formulario */
    private array|null $data;
    
   /**recebe true se executar com sucesso e false se houver Erro - */
    private $result;
    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    private array $listRegistryAdd;

   
    

    function getResult()
    {
        return $this->result;
        // //var_dump($this->result);
    }
        /** 
     * Recebe os valores do formulário.
     * Instancia o helper "AdmsValEmptyField" para verificar se todos os campos estão preenchidos 
     * Verifica se todos os campos estão preenchidos e instancia o método "valInput" para validar os dados dos campos
     * Retorna FALSE quando algum campo está vazio
     * 
     * @param array $data Recebe as informações do formulário
     * 
     * @return void
     */
    public function create(array $data = null)
    {
        $this->data = $data;
        // //var_dump($this->data);

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
        if ($this->viewLastAccessLevels()) {
            $this->data['created'] = date("Y-m-d H:i:s");

            $createAccessLevels = new \App\adms\Models\helper\AdmsCreate();
            $createAccessLevels->exeCreate("adms_access_levels", $this->data);
            if ($createAccessLevels->getResult()) {
                $_SESSION['msg'] = "<p class='alert-success'>Nível de acesso cadastrado com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0110: Nível de acesso não cadastrado com sucesso!</p>";
                $this->result = false;
            }
        }
    }
       
    
     /** 
     * Metodo para verificar qual he a ultima ordem que esta cadastrada no banco de dados
     */
    private function viewLastAccessLevels()
    {
        $viewLastAccessLevels = new \App\adms\Models\helper\AdmsRead();
        $viewLastAccessLevels->fullRead("SELECT order_levels FROM adms_access_levels ORDER BY order_levels DESC LIMIT 1");
        $this->resultBd = $viewLastAccessLevels->getResult();
        if ($this->resultBd) {
            $this->data['order_levels'] = $this->resultBd[0]['order_levels'] + 1;
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro - 0109: Nível de acesso não cadastrado com sucesso. Tente mais tarde!</div>";
            return false;
        }
    }
}