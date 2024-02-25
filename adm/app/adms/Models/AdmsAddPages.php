<?php

namespace App\adms\Models;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }

/** Cadastrar página no banco de dados
*/
class AdmsAddPages
{
    /**recebe as informações do formulario */
    private array|null $data;
    
   /**recebe true se executar com sucesso e false se houver Erro - */
    private $result;
      /** @var array $dataExitVal Recebe as informações que serão retiradas da validação*/
      private array $dataExitVal;
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
        $this->dataExitVal['icon'] = $this->data['icon'];
        $this->dataExitVal['obs'] = $this->data['obs'];
        unset($this->data['obs'], $this->data['icon']);

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
       
        $this->data['icon'] = $this->dataExitVal['icon'];
        $this->data['obs'] = $this->dataExitVal['obs'];
        $this->data['created'] = date("Y-m-d H:i:s");

        $createColor = new \App\adms\Models\helper\AdmsCreate();
        $createColor->exeCreate("adms_pages", $this->data);

        if( $createColor->getResult()){
             $_SESSION['msg'] = "<p class='alert-success'>Página cadastrada com sucesso!</p>";
             $this->result = true;
           
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0165: página não cadastrada com sucesso!</p>";
            $this->result = false;
        }      
     
    }
        /**
     * Metodo para pesquisar as informações que serão usadas no dropdown do formulário
     *
     * @return array
     */
    public function listSelect(): array
    {
        $list = new \App\adms\Models\helper\AdmsRead();
        $list->fullRead("SELECT id id_sit, name name_sit FROM adms_sits_pgs ORDER BY name ASC");
        $registry['sit_page'] = $list->getResult();

        $list->fullRead("SELECT id id_type, type, name name_type FROM adms_types_pgs ORDER BY name ASC");
        $registry['type_page'] = $list->getResult();

        $list->fullRead("SELECT id id_group, name name_group FROM adms_groups_pgs ORDER BY name ASC");
        $registry['group_page'] = $list->getResult();

        $this->listRegistryAdd = ['sit_page' => $registry['sit_page'], 'type_page' => $registry['type_page'], 'group_page' => $registry['group_page']];

        return $this->listRegistryAdd;
    }
}

