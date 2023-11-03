<?php

namespace App\adms\Models;



/** 
 * Solicitar novo link para cadastrar nova senha
 */
class AdmsRecoverPassword
{
    /**recebe as informações do formulario o (email)*/
    private array|null $data;
    /**recebe true se executar com sucesso e false se houver erro */
    private $result;
    /** @var string $fromEmail Recebe o e-mail do remetente */
    private string $fromEmail =  EMAILADM;
    /**Recebe os registros do banco de dados */
    private array|null $resultBd;
    /** $firstName recebe o primeiro nome do usuário*/
    private string $firstName;
    /**recebe os dados do conteúdo do email */
    private array $emailData;
    /** $url recebe a url com endereço para o usuário confirmar o email*/
    private string $url;

    private array $dataSave;




    function getResult(): bool
    {
        return $this->result;
        // var_dump($this->result);
    }
    
    public function recoverPassword(array $data = null): void
    {
        $this->data = $data;
        var_dump($this->data);
        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->ValUser();
            

        } else {
            $this->result = false;
        }
    }
    /**faz a conssulta no banco de dados e retorna true continua se retornar false apresenta email não encontrado */
    private function ValUser(): void
    {
        $newConfEmail = new \App\adms\Models\helper\AdmsRead();
        $newConfEmail->fullRead("SELECT id, name, email FROM adms_users WHERE email=:email LIMIT :limit ", "email={$this->data['email']}&limit=1");

        $this->resultBd = $newConfEmail->getResult();
        var_dump($this->resultBd);
        if ($this->resultBd) {
            $this->valConfEmail();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: email não cadastrado!</p>";
            $this->result = false;
        }
    }
   /**
    * valConfEmail salva uma chave na coluna recover_passord, instancia a helper quq edita no banco de dados,se o getResult for true instancia a sendEmail para enviar o email
    *
    * @return void
    */
    private function valConfEmail(): void
    {
      

            $this->dataSave['recover_password'] = password_hash(date("y-m-d H:i:s") . $this->resultBd[0]['id'], PASSWORD_DEFAULT);
            $this->dataSave['modified'] = date("Y-m-d H:i:s");

        

            $upNewConfEmail = new \App\adms\Models\helper\AdmsUpdate();
            $upNewConfEmail->exeUpdate("adms_users", $this->dataSave, "WHERE id=:id", "id={$this->resultBd[0]['id']}");
            if ($upNewConfEmail->getResult()) {
                // var_dump($this->resultBd[0]['recover_password']);
                // var_dump($this->dataSave['recover_password']);
                $this->resultBd[0]['recover_password'] = $this->dataSave['recover_password'];
                var_dump($this->resultBd[0]['recover_password']);
                $this->sendEmail();
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: link não enviado, tente novamente!</p>";
                $this->result = false;
            }

 
    }
    /**instancia o $sendEmail = new \App\adms\Models\helper\AdmsSendEmail();
     * instancia os metodos emailHTML() emaiTextL() que obtem os dados do corpo do email, e instancia o $sendEmail->sendEmail($this->emailData, 2); enviando os dados do corpo do email armazenado na $this->emailData essa é a helper que envia o email.

     */
    private function sendEmail(): void
    {
        $sendEmail = new \App\adms\Models\helper\AdmsSendEmail();
        $this->emailHTML();
        $this->emailText();
        $sendEmail->sendEmail($this->emailData, 2);
        if ($sendEmail->getResult()) {

            $_SESSION['msg'] = "<p style='color: green;'>Enviado e-mail com as instruções para recuperar a senha. Acesse sua caixa de email para recuperar a senha!</p>";
            $this->result = true;
        } else {
            $this->fromEmail = $sendEmail->getFromEmail();
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link E-mail com as instruções para recuperar a senha não enviado, tente novamente ou entre em contato com o e-mail {$this->fromEmail}!</p>";
            $this->result = false;
        }
    }

    private function emailHTML(): void
    {
        $this->resultBd[0]['name'];
        $name = explode(" ", $this->resultBd[0]['name']);
        $this->firstName = $name[0];

        $this->emailData['toEmail'] = $this->data['email'];
        $this->emailData['toName'] = $this->resultBd[0]['name'];
        $this->emailData['subject'] = "Recuperar senha";
        $this->url = URLADM . "update-password/index?key=" . $this->resultBd[0]['recover_password'];

        $this->emailData['contentHtml'] = "Prezado(a) {$this->firstName}<br><br>";
        $this->emailData['contentHtml'] .= "Você solicitou a alteração de senha!<br><br>";
        $this->emailData['contentHtml'] .= "Para continuar o proceso de solicitação de senha, clique no link abaixo ou cole no navegador: <br><br>";
        $this->emailData['contentHtml'] .= "<a href='{$this->url}'>{$this->url}</a><br><br>";
        $this->emailData['contentHtml'] .= "Se vc não solicitou alteração de senha, nenhuma ação é necessária. sua senha permanecerá a mesma até que você ative seu código<br><br>";
    }

    private function emailText(): void
    {
        $this->emailData['contentText'] = "Prezado(a) {$this->firstName}\n\n";
        $this->emailData['contentText'] .= "Você solicitou a alteração de senha!\n\n";
        $this->emailData['contentText'] .= "Para continuar o proceso de solicitação de senha, clique no link abaixo ou cole no navegador: \n\n";
        $this->emailData['contentText'] .=  $this->url . "\n\n";
        $this->emailData['contentText'] .= "Se vc não solicitou alteração de senha, nenhuma ação é necessária. sua senha permanecerá a mesma até que você ative seu código.\n\n";
    }
}
