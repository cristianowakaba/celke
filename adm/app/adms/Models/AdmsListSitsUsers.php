<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')) {
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
    // var_dump($this->result);
  }
  /**
     * @return bool Retorna a paginação
     */
    function getResultPg(): string|null
    {
        return $this->resultPg;
    }

  /**
   * instancia a helper de leitura no banco de dados,
   * atribui o allias  sit para a tabela adms_sits_users e col para a tabela adms_colors
   * seleciona coluna id e name da tabela adms_sits_userse e coluna color da tabela adms_colors
   * usa inner join para trazer informa
   *
   * @return void
   */
  public function listSitsUsers(int $page = null): void
  {
    $this->page = (int) $page ? $page : 1;
    //var_dump($this->page );
    $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-sits-users/index');
    $pagination->condition($this->page, $this->limitResult);
    $pagination->pagination("SELECT COUNT(usr.id) AS num_result FROM adms_sits_users usr");
    $this->resultPg = $pagination->getResult();
    //var_dump($this->resultPg);

    $listSitsUsers = new \App\adms\Models\helper\AdmsRead();
    $listSitsUsers->fullRead("SELECT sit.id, sit.name,
                            col.color 
                            FROM adms_sits_users sit
                            INNER JOIN adms_colors AS col ON col.id=sit.adms_color_id
                            ORDER BY sit.id DESC
                            LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$pagination->getOffset()}");
    $this->resultBd = $listSitsUsers->getResult();

    if ($this->resultBd) {

      $this->result = true;
    } else {
      $_SESSION['msg'] = "<p style='color:#f00'>Erro - 0055: nenhum usuário encontrado!</p>";
      $this->result = false;
    }
  }
}
