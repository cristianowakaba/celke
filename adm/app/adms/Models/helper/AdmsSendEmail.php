<?php

namespace App\adms\Models\helper;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Classe genérica para enviar e-mail
 *
 * @author Celke
 */
class AdmsSendEmail
{
    /** @var array $data Receber as informações do conteúdo do e-mail */
    private array $data;

    /** @var array $dataInfoEmail Receber as credenciais do e-mail */

    private array $dataInfoEmail;
    
    private $resultBd;
    

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var string $fromEmail Recebe o e-mail do remetente cadastrado no banco de dados ex: suporte ou atendimento */
    private string $fromEmail= EMAILADM;
    /**$optionConfEmail Recebe o id do e-mail que será utilizado para enviar e-mail */
    private int $optionConfEmail;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        var_dump($this->result);
        return $this->result;
       
    }
    /**retorna o email do remetente */
    function getFromEmail():string
    {
        return $this->fromEmail;
        
    }
/**método para enviar email */
    public function sendEmail(array $data ,int $optionConfEmail): void
    {
        $this->data=$data;
       
    /**$this->optionConfEmail recebe id do email a ser utilizado */
        $this->optionConfEmail = $optionConfEmail;
    //    //enail do destinátario
    //     $this->data['toEmail'] = "cesar@celke.com.br";
    //     // recebe nome do destinatário
    //     $this->data['toName'] = "Cesar";
    //     // assunto(titulo do email)
    //     $this->data['subject'] = "Confirma e-mail";
    //     //conteúdo do email em html
    //     $this->data['contentHtml'] = "Olá <b>Cesar</b><br><p>Cadastro realizado com sucesso!</p>";
    //     //conteúdo em texto
    //     $this->data['contentText'] = "Olá Cesar \n\nCadastro realizado com sucesso!";

        $this->infoPhoMailer();
    }
    /**infoPhoMailer() vai instanciar a helper AdmsRead() para ler as credenciais de forma dinamica */
    private function infoPhoMailer():void
    {
       $confEmail= new \App\adms\Models\helper\AdmsRead();
       $confEmail->fullRead("SELECT name, email, host, username, password,smtpsecure,port FROM  adms_confs_emails WHERE id=:id LIMIT :limit ","id={$this->optionConfEmail}&limit=1");
       $this->resultBd=$confEmail->getResult();
       if($this->resultBd){
        var_dump($this->resultBd);
        // ao inves de ter estatico pega d eforma dinamica do banco de dados as credenciais do servidor 
        $this->dataInfoEmail['host'] =$this->resultBd[0]['host'] ;
        $this->dataInfoEmail['fromEmail'] = $this->resultBd[0]['email'];
        $this->fromEmail = $this->dataInfoEmail['fromEmail'];
        $this->dataInfoEmail['fromName'] = $this->resultBd[0]['name'];
        $this->dataInfoEmail['username'] = $this->resultBd[0]['username'];
        $this->dataInfoEmail['password'] = $this->resultBd[0]['password'];
        $this->dataInfoEmail['smtpsecure'] =$this->resultBd[0]['smtpsecure'];
        $this->dataInfoEmail['port'] = $this->resultBd[0]['port'];
      
        $this->sendEmailPhpMailer();
    }else{
      
        $this->result = false;
    }
    }
/**cria o objeto $mail = new PHPMailer(true); envia as credenciais do servidor*/
    private function sendEmailPhpMailer(): void
    {
        $mail = new PHPMailer(true);

        try {
           
            //credenciais do sevidor;
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host       = $this->dataInfoEmail['host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->dataInfoEmail['username'];
            $mail->Password   = $this->dataInfoEmail['password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $this->dataInfoEmail['port'];
            
 

            $mail->setFrom($this->dataInfoEmail['fromEmail'], $this->dataInfoEmail['fromName']);//quem esta enviando e nome de quem esta enviando
            $mail->addAddress($this->data['toEmail'], $this->data['toName']);//quem esta recebendo, email e nome

            $mail->isHTML(true);// se tem conteudo html deixa true
            $mail->Subject = $this->data['subject'];//assunto
            $mail->Body    = $this->data['contentHtml'];//conteudo html 
            $mail->AltBody = $this->data['contentText'];//conteudo texto
//objeto $mail instacia o metodo send()e envia as credenciais e conteudo do email que estão no objeto $mail acima.
            $mail->send();

            $this->result = true;
        } catch (Exception $e) {
            echo $e;
            $this->result = false;
        }
    }
}


