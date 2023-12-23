<?php

namespace App\adms\Models;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }

/** Cadastrar situação usuário no banco de dados
*/
class AdmsAddSitsUsers
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

        $createSitUser = new \App\adms\Models\helper\AdmsCreate();
        $createSitUser->exeCreate("adms_sits_users", $this->data);

        if($createSitUser->getResult()){
             $_SESSION['msg'] = "<p style='color: green;'>Situação cadastrada com sucesso!</p>";
             $this->result = true;
           
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro - 0023: Situação não cadastrada com sucesso!</p>";
            $this->result = false;
        }      
     
    }
   /**
    * instancia a helper que faz a leitura dos registros no BD , atribui a um objeto com uma posicao sit e atribui chave sit e valor objeto criado ao atributo $this->listRegistryAdd
    *
    * @return array
    */
    public function listSelect(): array
    {
        $list = new \App\adms\Models\helper\AdmsRead();
        $list->fullRead("SELECT id id_col, name name_col FROM adms_colors ORDER BY name ASC");
        $registry['col'] = $list->getResult();
       var_dump($registry['col']);

       $this->listRegistryAdd = ['col' => $registry['col']];
       var_dump($this->listRegistryAdd); 
        return $this->listRegistryAdd;
    }
        
}
    
    

   