<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
  /*  header("Location:/"); */
die("Erro: Página não encontrada!<br>");
}
/**
 * listar situacao do usuário do banco de dados
*/
class AdmsListSitsUsers 
{
   
    
   /**recebe true se executar com sucesso e false se houver erro */
    private bool $result;
    /**Recebe os registros do banco de dados */
    private array|null $resultBd;

    
   
    
/**
 * 
 *recebe true se executar com sucesso e false se houver erro 
 *
 * @return boolean
 */
    function getResult():bool
    {
        return $this->result;
       
    }
    /**
     * retorna os  registros do  BD
     *
     * @return array|null
     */
    function getResultBd():array|null
    {
        return $this->resultBd;
        // var_dump($this->result);
    }
    /**
     * instancia a helper de leitura no banco de dados,
     * atribui o allias  sit para a tabela adms_sits_users e col para a tabela adms_colors
     * seleciona coluna id e name da tabela adms_sits_userse e coluna color da tabela adms_colors
     * usa inner join para trazer informa
     *
     * @return void
     */
    public function listSitsUsers():void
    {
      $listSitsUsers = new \App\adms\Models\helper\AdmsRead();
      $listSitsUsers->fullRead("SELECT sit.id, sit.name,
                            col.color 
                            FROM adms_sits_users sit
                            INNER JOIN adms_colors AS col ON col.id=sit.adms_color_id
                            ORDER BY sit.id DESC");
      $this->resultBd=$listSitsUsers->getResult();
      
      if($this->resultBd){
        
        $this->result=true;
      }else{
        $_SESSION['msg']="<p style='color:#f00'>Erro: nenhum usuário encontrado!</p>";
        $this->result=false;

      }


    }

   
        
}
    
    

