<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')) {
  /*  header("Location:/"); */
  die("Erro: Página não encontrada!<br>");
}
/**
 * listar situacao da pÁGINA
 */
class AdmsListSitsPages
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
     * Metodo faz a pesquisa das situações de página na tabela adms_sits_pgs e lista as informações na view
     * Recebe o paramentro "page" para que seja feita a paginação do resultado
     * @param integer|null $page
     * @return void
     */
  public function listSitsPages(int $page = null): void
  {
    $this->page = (int) $page ? $page : 1;
   // var_dump($this->page);
    $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-sits-pages/index');
    $pagination->condition($this->page, $this->limitResult);
    $pagination->pagination("SELECT COUNT(sit_pgs.id) AS num_result FROM adms_sits_pgs sit_pgs");
    $this->resultPg = $pagination->getResult();
    //var_dump($this->resultPg);

    $listSitsPages= new \App\adms\Models\helper\AdmsRead();
    $listSitsPages->fullRead("SELECT sit_pgs.id, sit_pgs.name,
                           col.color 
                            FROM adms_sits_pgs sit_pgs
                            INNER JOIN adms_colors AS col ON col.id=sit_pgs.adms_color_id
                            ORDER BY sit_pgs.id DESC
                            LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$pagination->getOffset()}");
    $this->resultBd = $listSitsPages->getResult();

    if ($this->resultBd) {

      $this->result = true;
    } else {
      $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0122: Situação da página não encontrada!</p>";
      $this->result = false;
    }
  }
  
}
