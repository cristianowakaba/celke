<?php

namespace App\adms\Models;
if(!defined('C8L6K7E')){
  /*  header("Location:/"); */
die("Erro: Página não encontrada!<br>");
}

/**
 * visualiza grupos de páginas
 */
class AdmsViewGroupsPages
{


  /**recebe true se executar com sucesso e false se houver erro */
  private bool $result=false;
  /**Recebe os registros do banco de dados */
  private array|null $resultBd;
  /** @var array|string|null $id recebeo id do registro */
  private int|string| null $id;





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
   * retorna os detalhes do registro
   *
   * @return array|null
   */
  function getResultBd(): array|null
  {
    return $this->resultBd;
    // //var_dump($this->result);
  }
  public function viewGroupsPages(int $id): void
  {
    $this->id = $id;
    // //var_dump($this->id);

    $viewGroupsPages = new \App\adms\Models\helper\AdmsRead();
    $viewGroupsPages->fullRead("SELECT id, name,order_group_pg, created, modified
                      FROM  adms_groups_pgs
                      WHERE id=:id
                        LIMIT :limit",
                        "id={$this->id}&limit=1");

    $this->resultBd = $viewGroupsPages->getResult();
    
    // //var_dump($this->resultBd );
    if ($this->resultBd) {

      $this->result = true;
    } else {
      $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0144: grupo de páginas não encontrada!</p>";
      $this->result = false;
    }
  }
}
