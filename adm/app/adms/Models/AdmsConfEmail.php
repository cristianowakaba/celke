<?php

namespace App\adms\Models;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }

use App\adms\Models\helper\AdmsConn;
use PDO;

/** 
 * confirmar o cadastro do usuário, alterando a situação no banco de dados.
 */
class AdmsConfEmail extends AdmsConn
{
    /* recebe a chave para confirmar o cadastro */
    private string $key;
    /**recebe true se executar com sucesso e false se houver erro */
    private $result;
    /**Recebe os registros do banco de dados */
    private array|null $resultBd;
    private array $dataSave;

 /**recebe true se executar com sucesso e false se houver erro */
    function getResult()
    {
        return $this->result;
        // var_dump($this->result);
    }
    /**recebe a $key  se receber instancia a helper generica AdmsRead() e faz a consulta se tiver resultado instancia o metodo updateSitUser() */
    public function confEmail(string $key): void
    {
        $this->key = $key;
        var_dump($this->key);
        if (!empty($this->key)) {
            $viewKeyConfEmail = new \App\adms\models\helper\AdmsRead();
            $viewKeyConfEmail->fullRead("SELECT id  FROM adms_users WHERE conf_email =:conf_email Limit :limit", "conf_email={$this->key}&limit=1");

            $this->resultBd = $viewKeyConfEmail->getResult();

            if ($this->resultBd) {
                $this->updateSitUser();
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro 0025: Necessário confirmar o e-mail, solicite novo link <a href='".URLADM."new-conf-email/index'> Clique Aqui</a></p>";
                $this->result = false;
               
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro 0026: Necessário confirmar o e-mail, solicite novo link <a href='".URLADM."new-conf-email/index'> Clique Aqui</a></p>";
            $this->result = false;
        }
    }
    /**faz o update e edita a coluna conf_email e adms_sits_user_id ou seja a chave recebida e o id para ativo  1 */
    private function updateSitUser(): void
    {
        $this->dataSave['conf_email'] = null;
        $this->dataSave['adms_sits_user_id'] = 1;
        $this->dataSave['modified'] = date("Y-m-d H:i:s");
        // $conf_email = null;
        // $adms_sits_user_id=1;

        $upConfEmail = new \App\adms\Models\helper\AdmsUpdate();
        $upConfEmail->exeUpdate("adms_users", $this->dataSave, "WHERE id=:id", "id={$this->resultBd[0]['id']}");

        if ($upConfEmail->getResult()) {
            $_SESSION['msg'] = "<p style='color: green;'>E-mail ativado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro 0027: Necessário confirmar o e-mail, solicite novo link <a href='".URLADM."new-conf-email/index'> Clique Aqui</a></p>";
                    $this->result=false;
        }


        //   $query_ativate_user = "UPDATE adms_users SET conf_email=:conf_email, adms_sits_user_id=:adms_sits_user_id, modified= now() WHERE id=:id LIMIT 1";

        //  $actvivate_email = $this->connectDb()->prepare($query_ativate_user);
        //  $actvivate_email->bindParam(':conf_email',$conf_email);
        //  $actvivate_email->bindParam(':adms_sits_user_id',$adms_sits_user_id);
        //  $actvivate_email->bindParam(':id',$this->resultBd[0]['id']);
        //  $actvivate_email->execute();

        //  if($actvivate_email->rowCount()){
        //     $_SESSION['msg'] = "<p style='color: green;'>E-mail ativado com sucesso!</p>";
        //         $this->result=true;
        //  }else{
        //     $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link inválido</p>";
        //         $this->result=false;
        //  }
    }
}
