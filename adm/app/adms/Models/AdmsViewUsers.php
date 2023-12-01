<?php

namespace App\adms\Models;
if(!defined('C8L6K7E')){
  /*  header("Location:/"); */
die("Erro: Página não encontrada!<br>");
}

/**
 * visualizar o usuários do banco de dados
 */
class AdmsViewUsers
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
    // var_dump($this->result);
  }
  public function viewUser(int $id): void
  {
    $this->id = $id;
    // var_dump($this->id);

    $viewUser = new \App\adms\Models\helper\AdmsRead();
    $viewUser->fullRead("SELECT usr.id, usr.name AS name_usr, usr.nickname, usr.email,
    usr.user, usr.image, usr.created, usr.modified,
                        sit.name AS name_sit,
                        col.color
                        FROM adms_users AS usr
                        INNER JOIN adms_sits_users AS sit 
                        ON sit.id=usr.adms_sits_user_id 
                        INNER JOIN adms_colors AS col ON col.id=sit.adms_color_id 
                        WHERE usr.id=:id
                        LIMIT :limit",
                        "id={$this->id}&limit=1");

    $this->resultBd = $viewUser->getResult();
    
    // var_dump($this->resultBd );
    if ($this->resultBd) {

      $this->result = true;
    } else {
      $_SESSION['msg'] = "<p style='color:#f00'>Erro: Usuário nãosss encontrado!</p>";
      $this->result = false;
    }
  }
}
