<?php

namespace App\adms\Models;
if(!defined('C8L6K7E')){
  /*  header("Location:/"); */
die("Erro: Página não encontrada!<br>");
}

/**
 * visualizar situação do usuários do banco de dados
 */
class AdmsViewSitsUsers
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
  public function viewSitUser(int $id): void
  {
    $this->id = $id;
    // //var_dump($this->id);

    $viewSitUser = new \App\adms\Models\helper\AdmsRead();
    $viewSitUser->fullRead("SELECT sit.id, sit.name, sit.created,sit.modified,col.color
                      FROM adms_sits_users AS sit
                      INNER JOIN adms_colors AS col ON col.id=sit.adms_color_id
                      WHERE sit.id=:id
                        LIMIT :limit",
                        "id={$this->id}&limit=1");

    $this->resultBd = $viewSitUser->getResult();
    
    // //var_dump($this->resultBd );
    if ($this->resultBd) {

      $this->result = true;
    } else {
      $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0073: Usuário não encontrado!</p>";
      $this->result = false;
    }
  }
}
