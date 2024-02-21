<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')) {
  /*  header("Location:/"); */
  die("Erro: Página não encontrada!<br>");
}
/**
 * listar tipos de página
 */
class AdmsListGroupsPages
{

  /**recebe true se executar com sucesso e false se houver erro */
  private bool $result;
  /**Recebe os registros do banco de dados */
  private array|null $resultBd;
  /** @var string|int|null $page Recebe o número página */
  private string|int|null $page;
  /** @var int $page Recebe a quantidade de registros que deve retornar do banco de dados */
  private int $limitResult = 40;
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
  public function listGroupsPages(int $page = null):void
    {
        $this->page = (int) $page ? $page : 1;

        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-groups-pages/index');
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_groups_pgs");
        $this->resultPg = $pagination->getResult();
    //var_dump($this->resultPg);

    
    $listGroupsPages = new \App\adms\Models\helper\AdmsRead();
    $listGroupsPages->fullRead("SELECT id, name, order_group_pg 
                        FROM adms_groups_pgs
                        ORDER BY order_group_pg ASC
                        LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$pagination->getOffset()}");

$this->resultBd = $listGroupsPages->getResult();
if($this->resultBd){
    $this->result = true;
}else{
  $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0143: nenhum usuário encontrado!</p>";
    $this->result = false;
}
}


}
