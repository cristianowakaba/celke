<?php

namespace App\adms\Models;
if(!defined('C8L6K7E')){
  /*  header("Location:/"); */
die("Erro: Página não encontrada!<br>");
}

/**
 * página inicial do sistema administrativo
 */
class AdmsDashboard
{


  /**recebe true se executar com sucesso e false se houver erro */
  private bool $result=false;
  /**Recebe os registros do banco de dados */
  private array|null $resultBd;
  




/**
 * retorna true quando eecutar o processo com sucesso ou false quando houver erro
 *
 * @return boolean
 */
  function getResult(): bool
  {
    return $this->result;
  }
  /**
   * retorna os dados
   *
   * @return array|null
   */
  function getResultBd(): array|null
  {
    return $this->resultBd;
    // //var_dump($this->result);
  }
  /**
     * método retornar dados para o dashboard
     */
       
  public function countUsers(): void
  {

    

    $countUsers = new \App\adms\Models\helper\AdmsRead();
    $countUsers->fullRead("SELECT COUNT(id) AS qnt_users FROM adms_users");
                        

    $this->resultBd = $countUsers->getResult();
    
    // //var_dump($this->resultBd );
    if ($this->resultBd) {

      $this->result = true;
    } else {
      /* $_SESSION['msg'] = "<p style='color:#f00'>Erro - 0074: Usuário nãosss encontrado!</p>"; */
      $this->result = false;
    }
  }
}
