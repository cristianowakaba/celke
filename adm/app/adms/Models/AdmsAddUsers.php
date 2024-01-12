<?php

namespace App\adms\Models;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }

/** cadastrar usuário no banco de dados
*/
class AdmsAddUsers
{
    /**recebe as informações do formulario */
    private array|null $data;
    
   /**recebe true se executar com sucesso e false se houver Erro - */
    private $result;

    private array $listRegistryAdd;

   
    

    function getResult()
    {
        return $this->result;
        // //var_dump($this->result);
    }

    public function create(array $data = null)
    {
        $this->data = $data;
        // //var_dump($this->data);

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();       
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->valInput();
             
        } else {
            $this->result = false;
        }
    }

    private function valInput():void
    {
    
       $valEmail= new \App\adms\Models\helper\AdmsValEmail();
       $valEmail->validateEmail($this->data['email']);

       $valEmailSingle = new  \App\adms\Models\helper\AdmsValEmailSingle();
       $valEmailSingle->validateEmailSingle($this->data['email']);

       $valPassword =new \App\adms\Models\helper\AdmsValPassword();
       $valPassword->validatePassword($this->data['password']);

       $valUserSingleLogin = new \App\adms\Models\helper\AdmsValUserSingle();
       $valUserSingleLogin->validateUserSingle($this->data['user']);




// se o email for valido e for unico e a senha for validada e se o usuaro for unico instancia o $this->add() e cadastra o usuario; 
       if(($valEmail->getResult())and ($valEmailSingle->getResult())and($valPassword->getResult())and $valUserSingleLogin->getResult()){
        $this->add();
       }else{
        $this->result= false;
       }
    }
    /**
     * possui os dados, senha email,chave criptografada etc., que serão enviados através do $this->data para o helper de criação AdmsCreate()
     *
     * @return void
     */
    private function add(): void
    {
        $this->data['password'] = password_hash($this->data['password'], PASSWORD_DEFAULT);
        $this->data['conf_email']= password_hash($this->data['password']. date("Y-m-d H:i:s"),PASSWORD_DEFAULT);
        $this->data['created'] = date("Y-m-d H:i:s");

        

        $createUser = new \App\adms\Models\helper\AdmsCreate();
        $createUser->exeCreate("adms_users", $this->data);

        if($createUser->getResult()){
             $_SESSION['msg'] = "<p class='alert-success'>Usuário cadastrado com sucesso!</p>";
             $this->result = true;
           
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0024: Usuário não cadastrado com sucesso!</p>";
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
        $list->fullRead("SELECT id id_sit, name name_sit FROM adms_sits_users ORDER BY name ASC");
        $registry['sit'] = $list->getResult();
       /*  //var_dump($registry['sit']); */
        $this->listRegistryAdd = ['sit' => $registry['sit']];
        /* //var_dump($this->listRegistryAdd); */
        return $this->listRegistryAdd;
    }
        
}
    
    

   