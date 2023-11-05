<?php

namespace App\adms\Models;


/**
*/
class AdmsListUsers 
{
   
    
   /**recebe true se executar com sucesso e false se houver erro */
    private bool $result;
    /**Recebe os registros do banco de dados */
    private array|null $resultBd;

    
   
    

    function getResult():bool
    {
        return $this->result;
       
    }
    function getResultBd():array|null
    {
        return $this->resultBd;
        // var_dump($this->result);
    }
    public function listUsers():void
    {
      $listUsers = new \App\adms\Models\helper\AdmsRead();
      $listUsers->fullRead("SELECT id, name,email FROM adms_users ");
      $this->resultBd=$listUsers->getResult();
      
      if($this->resultBd){
        
        $this->result=true;
      }else{
        $_SESSION['msg']="<p style='color:#f00'>Erro: nenhum usuário encontrado!</p>";
        $this->result=false;

      }


    }

   
        
}
    
    

