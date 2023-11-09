<?php

namespace App\adms\Models;


/** cadastrar usuário no banco de dados
*/
class AdmsAddUsers
{
    /**recebe as informações do formulario */
    private array|null $data;
    
   /**recebe true se executar com sucesso e false se houver erro */
    private $result;

   
    

    function getResult()
    {
        return $this->result;
        // var_dump($this->result);
    }

    public function create(array $data = null)
    {
        $this->data = $data;
        // var_dump($this->data);

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
       $valUserSingleLogin->validateUserSingleLogin($this->data['user']);




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
             $_SESSION['msg'] = "<p style='color: green;'>Usuário cadastrado com sucesso!</p>";
             $this->result = true;
           
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não cadastrado com sucesso!</p>";
            $this->result = false;
        }      
     
    }
   
   
        
}
    
    

   