<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')) {
  /*  header("Location:/"); */
  die("Erro: Página não encontrada!<br>");
}
/**
 * listar os usuários do banco de dados
 */
class AdmsListUsers
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
  function getResult(): bool
  {
    return $this->result;
  }
  /**
   * retorna os  registros do  BD
   *
   * @return array|null
   */
  function getResultBd(): array|null
  {
    return $this->resultBd;
    // var_dump($this->result);
  }
  public function listUsers(): void
  {
    $listUsers = new \App\adms\Models\helper\AdmsRead();
    $listUsers->fullRead("SELECT usr.id, usr.name AS name_usr, usr.email, usr.adms_sits_user_id, 
    sit.name AS name_sit,
    col.color 
    FROM adms_users AS usr
    INNER JOIN adms_sits_users AS sit ON sit.id=usr.adms_sits_user_id 
    INNER JOIN adms_colors AS col ON col.id=sit.adms_color_id
    ORDER BY usr.id DESC");
    $this->resultBd = $listUsers->getResult();

    if ($this->resultBd) {

      $this->result = true;
    } else {
      $_SESSION['msg'] = "<p style='color:#f00'>Erro: nenhum usuário encontrado!</p>";
      $this->result = false;
    }
  }
}
