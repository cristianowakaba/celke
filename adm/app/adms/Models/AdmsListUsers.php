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
  /**Recebe o numero da página */
  private int $page;
   /** @var int $limitResult  recebe a quantidade de registros que deve retornar do banco de dados  por página */ 
   private int $limitResult =3;
   /** @var string|null $resultPg recebe a paginação */ 
   private string|null $resultPg;




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
  }
  /**
   * retorna a paginação
   *
   * @return array|null
   */
  function getResultPg(): string|null
  {
    return $this->resultPg;
  }
  public function listUsers( int $page = null): void
  {
    $this->page = (int) $page ? $page:1;
    // var_dump($this->page);

    $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-users/index');
    $pagination->condition($this->page, $this->limitResult);
    $pagination->pagination("SELECT COUNT(usr.id) AS num_result FROM adms_users usr");
    $this->resultPg = $pagination->getResult();
    //var_dump($this->resultPg);

    $listUsers = new \App\adms\Models\helper\AdmsRead();
    $listUsers->fullRead("SELECT usr.id, usr.name AS name_usr, usr.email, usr.adms_sits_user_id, 
    sit.name AS name_sit,
    col.color 
    FROM adms_users AS usr
    INNER JOIN adms_sits_users AS sit ON sit.id=usr.adms_sits_user_id 
    INNER JOIN adms_colors AS col ON col.id=sit.adms_color_id
    ORDER BY usr.id DESC
    LIMIT :limit OFFSET :offset","limit={$this->limitResult}&offset={$pagination->getOffset()}");

    $this->resultBd = $listUsers->getResult();

    if ($this->resultBd) {

      $this->result = true;
    } else {
      $_SESSION['msg'] = "<p style='color:#f00'>Erro - 0056: nenhum usuário encontrado!</p>";
      $this->result = false;
    }
  }
}
