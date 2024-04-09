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
  /** @var string|null $searchName Recebe o nome da situacao */
  private string|null $searchName;

  /** @var string|null $searchNameValue Recebe o nome da situacao */
  private string|null $searchNameValue;




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
   // var_dump($this->page);
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
      $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0055: nenhum usuário encontrado!</p>";
      $this->result = false;
    }
  }
  /**
   * Metodo faz a pesquisa das situações do usuário na tabela adms_sits_users e lista as informações na view
   * Recebe como parametro "page" para fazer a paginação
   * Recebe o paramentro "search_name" para pesquisar a situacao atraves do nome
   * @param integer|null $page
   * @param string|null $search_name
   * @return void
   */
  public function listSearchSitsUsers(int $page = null, string|null $search_name): void
  {
    //var_dump($search_name);
    $this->page = (int) $page ? $page : 1;
    $this->searchName = trim($search_name);
    //var_dump($this->searchName);
    $this->searchNameValue = "%" . $this->searchName . "%";
    //var_dump($this->searchNameValue);
    $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-sits-users/index', "?search_name={$this->searchName}");
    $pagination->condition($this->page, $this->limitResult);
    $pagination->pagination("SELECT COUNT(sit.id) AS num_result 
                                FROM adms_sits_users AS sit
                                WHERE sit.name LIKE :search_name", "search_name={$this->searchNameValue}");
    $this->resultPg = $pagination->getResult();

    $listSitsUsers = new \App\adms\Models\helper\AdmsRead();
    $listSitsUsers->fullRead("SELECT sit.id, sit.name,
                            col.color 
                            FROM adms_sits_users AS sit
                            INNER JOIN adms_colors AS col ON col.id=sit.adms_color_id
                            WHERE sit.name LIKE :search_name 
                            ORDER BY sit.id DESC
                            LIMIT :limit OFFSET :offset", "search_name={$this->searchNameValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

    $this->resultBd = $listSitsUsers->getResult();
    if ($this->resultBd) {
      $this->result = true;
    } else {
      $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nenhuma situação encontrada!</p>";
      $this->result = false;
    }
  }
}
