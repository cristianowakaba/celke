<?php

namespace App\adms\Models\helper;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * classe responsável por validar email o usuário unico, somente um cadastro pode utilizar o usuário
 */
class AdmsValUserSingle
{
    /** @var string $user Recebe o usuário que deve ser validado */
    private string $user;

    /** @var bool|null $edit Recebe a informação que é utilizada para verificar se é para validar usuário para cadastro ou edição */
    private bool|null $edit;

    /** @var int|null $id Recebe o id do usuário que deve ser ignorado quando estiver validando o usuário para edição */
    private int|null $id;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult():bool
    {
        return $this->result;
    }
   /**recebe o $user e verifica se tiver $edit e id for diferente entra no if editar senão entra no else e instancia o método fullRed  do AdmsRead e passa a query e  a parsestring, se tiver resultado o metogo getResul retorna true senão false*/
    public function validateUserSingle(string $user, bool|null $edit=null, int|null $id=null):void
    {
    $this->user=$user;
    $this->edit=$edit;
    $this->id=$id;

   $valUserSingle =new \App\adms\Models\helper\AdmsRead();
        if(($this->edit==true)and (!empty($this->id))){
            $valUserSingle->fullRead("SELECT id FROM adms_users WHERE (user=:user OR email =:email) AND id<>:id LIMIT :limit", "user={$this->user}&email={$this->user}&id={$this->id}&limit=1");
        }else{
            $valUserSingle->fullRead("SELECT id FROM adms_users WHERE user=:user LIMIT :limit","user={$this->user}&limit=1");
        }
        //se a query enviada no fullRead  encontrar resultado sera atribuida a $this->resultBd, ai verifica se for diferente de verdadeiro ou seja não tiver resultado significa que no banco de dados não tem o email ai entra no if e o  $this->result=true; senao entra no else e o  $this->result = false; com uma msg de email cadastrado
       $this->resultBd =$valUserSingle->getResult();
        if(!$this->resultBd){
            $this->result=true;
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0087: este usuário ja esta cadastrado!</p>";
          $this->result = false;
        }
      
    }    
}
