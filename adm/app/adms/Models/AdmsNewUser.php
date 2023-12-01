<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/** classe recebe os dados da controller NewUser e instancia a helper generica AdmsCreate para criar registro e instancia helper AdmsValEmptyField que verifica se tem campos vazios
 * instancia a AdmsValEmail para verificar se o email e valido e
 * instancia a AdmsValEmailSingle para verificar se o email não esta cadastrado
*/
class AdmsNewUser 
{
    /**recebe as informações do formulario */
    private array|null $data;
    
   /**recebe true se executar com sucesso e false se houver erro */
    private $result;

     /** @var string $fromEmail Recebe o e-mail do remetente */
    private string $fromEmail=  EMAILADM;
/** $firstName recebe o primeiro nome do usuário*/
    private string $firstName;
    /** $url recebe a url com a chave criptografada (link) sendo endereço que vai serredirecionado ao usuário clicar para confirmar o email*/
    private string $url;
    /**recebe os dados do conteúdo do email */
    private array $emailData;
    

    function getResult()
    {
        return $this->result;
        // var_dump($this->result);
    }
/**model metodo create recebe os dados da controller NewUser instancia helper AdmsValEmptyField ea classe valfield para validar os campos do formulario ,intancia helper generica AdmsCreate e a classe exeCreate que cadastra no banco de dados */
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
    /**instancia a helper classe AdmsValEmail e AdmsValEmailSingle para verificar se email esta cadastrado passa por parametro o email  $this->data['email']*/
    private function valInput():void
    {
        // após enviar o email recebe o resultado pelo getResult() se o email for valido e for unico instancia o $this->add(); 
       $valEmail= new \App\adms\Models\helper\AdmsValEmail();
       $valEmail->validateEmail($this->data['email']);

       $valEmailSingle = new  \App\adms\Models\helper\AdmsValEmailSingle();
       $valEmailSingle->validateEmailSingle($this->data['email']);

       $valPassword =new \App\adms\Models\helper\AdmsValPassword();
       $valPassword->validatePassword($this->data['password']);

       $valUserSingleLogin = new \App\adms\Models\helper\AdmsValUserSingleLogin();
       $valUserSingleLogin->validateUserSingleLogin($this->data['email']);




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
        $this->data['user'] = $this->data['email'];
        $this->data['conf_email']= password_hash($this->data['password']. date("Y-m-d H:i:s"),PASSWORD_DEFAULT);
        $this->data['created'] = date("Y-m-d H:i:s");

        

        $createUser = new \App\adms\Models\helper\AdmsCreate();
        $createUser->exeCreate("adms_users", $this->data);

        if($createUser->getResult()){
            // $_SESSION['msg'] = "<p style='color: green;'>Usuário cadastrado com sucesso!</p>";
            // $this->result = true;
            $this->sendEmail();
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não cadastrado com sucesso!</p>";
            $this->result = false;
        }      
     
    }
    /**sendEmail() instancia o helper para enviar email  e é instanciado quando o usuario for cadastrado*/
    private function sendEmail():void   
    {
        $this->contentEmailHtml();
        $this->contentEmailText();

       $sendemail =new \App\adms\Models\helper\AdmsSendEmail();
       $sendemail->sendEmail($this->emailData,2);

       if($sendemail->getResult()){
        
        $_SESSION['msg'] = "<p style='color: green;'>Usuário cadastrado com sucesso. Acesse sua caixa de e-mail para confirmar o e-mail</p>";
        $this->result =true;
       }else{
        $this->fromEmail=$sendemail->getFromEmail();
        $_SESSION['msg'] = "<p style='color: #f00;'>Usuário cadastrado com sucesso. Houve erro ao enviar o e-mail de confirmação, entre em contato com {$this->fromEmail} </p>";
        $this->result = true;
       }

      

       }
       private function contentEmailHtml():void
       {
       $name= explode(" ",$this->data['name']);
       $this->firstName = $name[0];

       $this->emailData['toEmail']=$this->data['email'];
       $this->emailData['toName']=$this->data['name'];
       $this->emailData['subject']="Confirmar sua conta";
       $this->url= URLADM. "conf-email/index?key=".$this->data['conf_email'];

       $this->emailData['contentHtml'] = "Prezado(a) {$this->firstName}<br><br>";
       $this->emailData['contentHtml'] .= "Agradecemos a sua solicitação de cadastro em nosso site!<br><br>";
       $this->emailData['contentHtml'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo: <br><br>";
       $this->emailData['contentHtml'] .= "<a href='$this->url'> $this->url</a><br><br>";
       $this->emailData['contentHtml'] .= "Esta mensagem foi enviada a você pela empresa XXX.<br>Você está recebendo porque está cadastrado no banco de dados da empresa XXX. Nenhum e-mail enviado pela empresa XXX tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.<br><br>"; 
   }
   private function contentEmailText(): void
   {
   
       $this->emailData['contentText'] = "Prezado(a) {$this->firstName}\n\n";
       $this->emailData['contentText'] .= "Agradecemos a sua solicitação de cadastro em nosso site!\n\n";
       $this->emailData['contentText'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo: \n\n";
       $this->emailData['contentText'] .= $this->url."\n\n";
       $this->emailData['contentText'] .= "Esta mensagem foi enviada a você pela empresa XXX.\nVocê está recebendo porque está cadastrado no banco de dados da empresa XXX. Nenhum e-mail enviado pela empresa XXX tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.\n\n";  
   }
        
}
    
    

    /*
    public function create(array $data = null)
    {
        $this->data = $data;
        //var_dump($this->data);

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            // Instanciar o metodo quando a classe he abstrata e a classe AdmsLogin é filha da classe AdmsConn
            $this->conn = $this->connectDb();

            $this->data['password'] = password_hash($this->data['password'], PASSWORD_DEFAULT);

            //var_dump($this->data);

            $query_new_user = "INSERT INTO adms_users (name, email, user, password, created) VALUES (:name, :email, :user, :password, NOW())";
            $add_new_user = $this->conn->prepare($query_new_user);
            $add_new_user->bindParam(":name", $this->data['name'], PDO::PARAM_STR);
            $add_new_user->bindParam(":email", $this->data['email'], PDO::PARAM_STR);
            $add_new_user->bindParam(":user", $this->data['email'], PDO::PARAM_STR);
            $add_new_user->bindParam(":password", $this->data['password'], PDO::PARAM_STR);

            $add_new_user->execute();

            if ($add_new_user->rowCount()) {
                $_SESSION['msg'] = "<p style='color: green;'>Usuário cadastrado com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não cadastrado com sucesso!</p>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    
    */
    
