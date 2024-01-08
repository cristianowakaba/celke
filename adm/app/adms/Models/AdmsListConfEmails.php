<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')) {
  /*  header("Location:/"); */
  die("Erro: Página não encontrada!<br>");
}
/**
 * listar Configurações de email
 */
class AdmsListConfEmails
{


  /**recebe true se executar com sucesso e false se houver erro */
  private bool $result;
  /**Recebe os registros do banco de dados */
  private array|null $resultBd;
  /** @var string|int|null $page Recebe o número página */
  private string|int|null $page;
  /** @var int $page Recebe a quantidade de registros que deve retornar do banco de dados */
  private int $limitResult = 1;
  /** @var string|null $page Recebe a páginação */
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
    // //var_dump($this->result);
  }
  /**
     * @return bool Retorna a paginação
     */
    function getResultPg(): string|null
    {
        return $this->resultPg;
    }

  /**
   
   *
   * @return void
   */
  public function ListConfEmails(int $page = null): void
  {
    $this->page = (int) $page ? $page : 1;
    ////var_dump($this->page );
    $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-conf-emails/index');
    $pagination->condition($this->page, $this->limitResult);
    $pagination->pagination("SELECT COUNT(col.id) AS num_result FROM adms_confs_emails As col");
    $this->resultPg = $pagination->getResult();
    // //var_dump($this->resultPg);

    $listConfEmails = new \App\adms\Models\helper\AdmsRead();
    $listConfEmails->fullRead("SELECT id,title, name,
                            email
                            FROM adms_confs_emails
                            ORDER BY id DESC
                            LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$pagination->getOffset()}");
    $this->resultBd = $listConfEmails->getResult();

    if ($this->resultBd) {
// //var_dump($this->resultBd);
      $this->result = true ;
    } else {
      $_SESSION['msg'] = "<p style='color:#f00'>Erro - 0089: Nenhum e-mail encontrado!</p>";
      $this->result = false;
    }
  }
}
