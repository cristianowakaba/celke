<?php

namespace App\adms\Models;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
 
use App\adms\Models\helper\AdmsConn;
use PDO;

/** 
 * Solicitar novo link para confirmar email
 */
class AdmsNewConfEmail extends AdmsConn
{
    /**recebe as informações do formulario */
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
    /**
     * recebe os dados, chave para cadastrar na coluna conf_email
     *
     * @var array
     */
    private array $dataSave;




    function getResult(): bool
    {
        return $this->result=false;
        // var_dump($this->result);
    }
    /**recebe os dados(email) dataForm por parametro através do $data , intancia helper para validar campos vazios, se estiver tudo preenchido instancia ValUser */
    public function newConfEmail(array $data = null): void
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
        $newConfEmail->fullRead("SELECT id, name, email,conf_email FROM adms_users WHERE email=:email LIMIT :limit ", "email={$this->data['email']}&limit=1");

        $this->resultBd = $newConfEmail->getResult();
        var_dump($this->resultBd);
        if ($this->resultBd) {
            $this->valConfEmail();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro 0061: email não cadastrado!</p>";
            $this->result = false;
        }
    }
    /**verifica se  a posição ($this->resultBd[0]['conf_email'])  esta vazia ou nula.salva a chave criptografada na coluna $this->dataSave['conf_email']  e instancia o helper AdmsUpdate() instancia o método sendEmail() */
    private function valConfEmail(): void
    {
        if ((empty($this->resultBd[0]['conf_email'])) or ($this->resultBd[0]['conf_email']) == null) {

            $this->dataSave['conf_email'] = password_hash(date("y-m-d H:i:s") . $this->resultBd[0]['id'], PASSWORD_DEFAULT);
            $this->dataSave['modified'] = date("Y-m-d H:i:s");

            //    $this->dataSave['exemplo1'] = password_hash(date("y-m-d H:i:s").$this->resultBd[0]['id'],PASSWORD_DEFAULT);

            //    $this->dataSave['exemplo2'] = password_hash(date("y-m-d H:i:s").$this->resultBd[0]['id'],PASSWORD_DEFAULT);

            $upNewConfEmail = new \App\adms\Models\helper\AdmsUpdate();
            $upNewConfEmail->exeUpdate("adms_users", $this->dataSave, "WHERE id=:id", "id={$this->resultBd[0]['id']}");
            if ($upNewConfEmail->getResult()) {
                $this->resultBd[0]['conf_email'] = $this->dataSave['conf_email'];
                $this->sendEmail();
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro 0062: link não enviado, tente novamente!</p>";
                $this->result = false;
            }

            //   $query_activate_user = "UPDATE adms_users SET conf_email=:conf_email, modified = NOW() WHERE id=:id LIMIT :limit";

            //  $activate_user= $this->connectDb()->prepare($query_activate_user);
            //  $activate_user->bindParam(':conf_email',$conf_email);
            //  $activate_user->bindParam(':id',$this->resultBd[0]['id']);
            //  $activate_user->bindValue(':limit', 1,PDO::PARAM_INT);
            //  $activate_user->execute();

            //  if($activate_user->rowCount()){
            //     var_dump($this->resultBd[0]['conf_email']);
            //     $this->resultBd[0]['conf_email']=$conf_email;


            //     $this->sendEmail();
            //     echo"Salvou nova chave : $conf_email<br>";
            //     $this->result = false;
            //  }else{

            //     $_SESSION['msg'] = "<p style='color: #f00;'>Erro: link não enviado, tente novamente!</p>";
            //     $this->result = false;
            //  }

            // $this->result = false; 
        } else {

            $this->sendEmail();
            // $this->result = false;
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

            $_SESSION['msg'] = "<p style='color: green;'>Novo link enviado com sucesso. Acesse a sua caixa de e-mail para confimar o e-mail!</p>";
            $this->result = true;
        } else {
            $this->fromEmail = $sendEmail->getFromEmail();
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro 0063: Link não enviado, tente novamente ou entre em contato com o e-mail {$this->fromEmail}!</p>";
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
        $this->emailData['subject'] = "Confirma sua conta";
        $this->url = URLADM . "conf-email/index?key=" . $this->resultBd[0]['conf_email'];

        $this->emailData['contentHtml'] = "Prezado(a) {$this->firstName}<br><br>";
        $this->emailData['contentHtml'] .= "Agradecemos a sua solicitação de cadastro em nosso site!<br><br>";
        $this->emailData['contentHtml'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo: <br><br>";
        $this->emailData['contentHtml'] .= "<a href='{$this->url}'>{$this->url}</a><br><br>";
        $this->emailData['contentHtml'] .= "Esta mensagem foi enviada a você pela empresa XXX.<br>Você está recebendo porque está cadastrado no banco de dados da empresa XXX. Nenhum e-mail enviado pela empresa XXX tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.<br><br>";
    }

    private function emailText(): void
    {
        $this->emailData['contentText'] = "Prezado(a) {$this->firstName}\n\n";
        $this->emailData['contentText'] .= "Agradecemos a sua solicitação de cadastro em nosso site!\n\n";
        $this->emailData['contentText'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo: \n\n";
        $this->emailData['contentText'] .=  $this->url . "\n\n";
        $this->emailData['contentText'] .= "Esta mensagem foi enviada a você pela empresa XXX.\nVocê está recebendo porque está cadastrado no banco de dados da empresa XXX. Nenhum e-mail enviado pela empresa XXX tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.\n\n";
    }
}
