<?php

namespace App\adms\Models\helper;
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
   $valEmailSingle =new \App\adms\Models\helper\AdmsRead();
        if(($this->edit==true)and (!empty($this->id))){
            $valEmailSingle->fullRead("SELECT id FROM adms_users WHERE (email=:email OR user =:user) AND id<>:id LIMIT :limit","email={$this->email}&:user={$this->email}&id={$this->id}&limit=1");
        }else{
            $valEmailSingle->fullRead("SELECT id FROM adms_users WHERE email=:email LIMIT :limit","email={$this->email}&limit=1");
        }
        //se a query enviada no fullRead  encontrar resultado sera atribuida a $this->resultBd, ai verifica se for diferente de verdadeiro ou seja não tiver resultado significa que no banco de dados não tem o email ai entra no iv e o  $this->result=true; senao entra no else e o  $this->result = false; com uma msg de email cadastrado
       $this->resultBd =$valEmailSingle->getResult();
        if(!$this->resultBd){
            $this->result=true;
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: este e-mail ja esta cadastrado!</p>";
          $this->result = false;
        }
      
    }    
}
