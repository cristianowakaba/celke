<?php

namespace App\adms\Models\helper;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * classe responsável por validar email unico
 */
class AdmsValEmailSingle
{
    private string $email;
    private bool|null $edit;
    private int|null $id;
    private bool $result;
    private array|null $resultBd;
   
    function getResult():bool
    {
        return $this->result;
    }
   /**recebe email edit e id por parametro , após receber instancia o helper AdmsRead para pesquisar no banco de dados */
    public function validateEmailSingle(string $email, bool|null $edit=null, int|null $id=null):void
    {
    $this->email=$email;
    $this->edit=$edit;
    $this->id=$id;
// recebe o email, instancia a classe AdmsRead() se $this->edit==true e o id for diferente de vazio significa que vai editar(veremos mais a frente o editar) ai instancia o fullread do if que pega o id diferente do id do usuario para ignorar o email, se nao for editar cai no else e instancia o fullread com a query, apos instancia o $valEmailSingle->getResult()
  $valEmailSingle = new \App\adms\Models\helper\AdmsRead();
        if (($this->edit == true) and (!empty($this->id))) {
            $valEmailSingle->fullRead("SELECT id FROM adms_users WHERE (email =:email OR user =:user) AND id <>:id LIMIT :limit", "email={$this->email}&user={$this->email}&id={$this->id}&limit=1");
        } else {
            $valEmailSingle->fullRead("SELECT id FROM adms_users WHERE email =:email LIMIT :limit", "email={$this->email}&limit=1");
        }
        //envia uma query que verifica se tem um id que possua o email ou usuario que estou enviando no banco de dados, tem que ser diferente do id que estou enviando, se voltar resultado quer dizer que o email ou senha esta cadastrado . verifica se resultbd for diferente ou seja nao tiver resultado retorna true e continua senão retorna false e umamsg de erro.
       $this->resultBd =$valEmailSingle->getResult();
       //var_dump( $this->resultBd);
        if(!$this->resultBd){
            $this->result=true;
        }else{
            //var_dump( $this->resultBd);
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0080: este e-mail ja esta cadastrado!.</p>";
          $this->result = false;
        }
      
    }    
}
